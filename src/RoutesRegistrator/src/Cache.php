<?php
declare(strict_types=1);

namespace RoutesRegistrator;

use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class Cache
{
    /** @var CacheInterface */
    private $cacheAdapter;
    /** @var LoggerInterface */
    private $logger;

    /**
     * Cache constructor.
     * @param CacheInterface $cacheAdapter
     * @param LoggerInterface $logger
     */
    public function __construct(
        CacheInterface $cacheAdapter,
        LoggerInterface $logger
    ) {
        $this->cacheAdapter = $cacheAdapter;
        $this->logger = $logger;
    }

    /**
     * @param Route[] $routes
     */
    public function saveAll(array $routes): void
    {
        try {
            $this->cacheAdapter->setMultiple($routes);
        } catch (InvalidArgumentException $exception) {
            $this->logger->error($exception->getMessage(), [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }
    }

    /**
     * @return Route[]
     */
    public function getAll(): array
    {
        $i = 0;
        $routes = [];

        try {
            while ($route = $this->cacheAdapter->get($i)) {
                $routes[] = $route;
                $i++;
            }
        } catch (InvalidArgumentException $exception) {
            $this->logger->error($exception->getMessage(), [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'index' => $i,
            ]);
        }

        return $routes;
    }
}