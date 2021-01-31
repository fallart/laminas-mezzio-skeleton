<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilder;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ReflectionException;
use RegexIterator;
use SplFileInfo;

class HandlersFinder
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * HandlersFinder constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function find(string $path, string $namespace): array
    {
        $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        /** @var SplFileInfo[] $handlerFiles */
        $handlerFiles = new RegexIterator($allFiles, '/Handler\.php$/');
        $handlers = [];

        foreach ($handlerFiles as $handlerFile) {
            $classname = $this->getClassname($path, $namespace, $handlerFile->getPathname());

            try {
                $reflection = new ReflectionClass($classname);

                if ($reflection->isSubclassOf(RequestHandlerInterface::class)) {
                    $handlers[] = $classname;
                }
            } catch (ReflectionException $ex) {
                $this->logger->debug($ex->getMessage(), ['trace' => $ex->getTraceAsString()]);
            }
        }

        return $handlers;
    }

    private function getClassname(string $dirPath, string $namespace, string $filePath): string
    {
        $classname = str_replace($dirPath, '', $filePath);
        $classname = str_replace('.php', '', $classname);
        $classname = str_replace(DIRECTORY_SEPARATOR, '\\', $classname);

        return $namespace . '\\' . $classname;
    }
}
