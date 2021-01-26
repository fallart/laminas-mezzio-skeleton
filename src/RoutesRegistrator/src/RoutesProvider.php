<?php
declare(strict_types=1);

namespace RoutesRegistrator;

class RoutesProvider
{
    /** @var HandlersFinder */
    private $handlersFinder;
    /** @var ConfigInterface */
    private $config;
    /** @var RouteGenerator */
    private $routeGenerator;
    /** @var Cache */
    private $cache;

    public function __construct(
        HandlersFinder $handlersFinder,
        ConfigInterface $config,
        RouteGenerator $routeGenerator,
        Cache $cache = null
    ) {
        $this->handlersFinder = $handlersFinder;
        $this->config = $config;
        $this->routeGenerator = $routeGenerator;
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

    private function load(): array
    {
        $routes = [];
        $handlers = $this->handlersFinder->find($this->config->getRoutesDir(), $this->config->getNamespace());

        foreach ($handlers as $handlerClassName) {
            $routes[] = $this->routeGenerator->generate($handlerClassName);
        }

        return $routes;
    }
}