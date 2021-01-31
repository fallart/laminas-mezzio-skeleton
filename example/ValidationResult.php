<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilderExample;

use AFaller\Psr7RoutesBuilder\Validation\ValidationResultInterface;

class ValidationResult implements ValidationResultInterface
{
    /** @var bool */
    private $valid;
    /** @var array */
    private $validData;
    /** @var array */
    private $messages;

    public function __construct(bool $valid, array $validData = [], array $messages = [])
    {
        $this->valid = $valid;
        $this->validData = $validData;
        $this->messages = $messages;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * @return array
     */
    public function getValidData(): array
    {
        return $this->validData;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
