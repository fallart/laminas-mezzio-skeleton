<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilder\Handler;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface DescribedHandlerInterface extends RequestHandlerInterface
{
    public static function getDescription(): string;

    /**
     * @return string[]
     */
    public static function getMethods(): array;

    public function getPipe(): ?MiddlewareInterface;
}
