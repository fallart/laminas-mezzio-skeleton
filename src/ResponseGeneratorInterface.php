<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilder;

use Psr\Http\Message\ResponseInterface;

interface ResponseGeneratorInterface
{
    public function generate(array $data, int $code, array $headers = []): ResponseInterface;
}