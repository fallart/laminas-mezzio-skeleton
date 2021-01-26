<?php
declare(strict_types=1);

namespace RoutesRegistrator;

interface ResponseGeneratorInterface
{
    public function generate(array $data, int $code, array $headers = []);
}