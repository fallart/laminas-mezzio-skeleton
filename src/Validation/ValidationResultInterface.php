<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilder\Validation;

interface ValidationResultInterface
{
    public function isValid(): bool;

    public function getValidData(): array;

    public function getMessages(): array;
}