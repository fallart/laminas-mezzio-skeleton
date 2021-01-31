<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilder\Exception;

use Exception;

class RequestValidationException extends Exception
{
    /** @var array */
    private $validationErrors;

    public function __construct(array $validationErrors)
    {
        parent::__construct('Some errors found in request!');
        $this->validationErrors = $validationErrors;
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }
}
