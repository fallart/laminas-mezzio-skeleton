<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilder;

class RoutesProvider
{
    /** @var HandlersFinder */
    private $handlersFinder;
    /** @var ConfigInterface */
    private $config;
    /** @var RouteFactory */
    private $routeFactory;
    /** @var CacheInterface */
    private $cache;

    public function __construct(
        HandlersFinder $handlersFinder,
        ConfigInterface $config,
        RouteFactory $routeGenerator,
        CacheInterface $cache = null
    ) {
        $this->handlersFinder = $handlersFinder;
        $this->config = $config;
        $this->routeFactory = $routeGenerator;
        $this->cache = $cache;
    }

    /**
     * @return Route[]
     */
    public function getAll(): array
    {
        if (!$this->config->isCacheEnabled() || null === $this->cache) {
            return $this->load();
        }

        $routes = $this->cache->getAll();

        if (empty($routes)) {
            $routes = $this->load();
            $this->cache->saveAll($routes);
        }

        return $routes;
    }

    /**
     * @return Route[]
     */
    private function load(): array
    {
        $routes = [];
        $handlers = $this->handlersFinder->find($this->config->getRoutesDir(), $this->config->getNamespace());

        foreach ($handlers as $handlerClassName) {
            $routes[] = $this->routeFactory->create($handlerClassName);
        }

        return $routes;
    }
}