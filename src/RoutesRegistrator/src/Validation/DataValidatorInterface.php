<?php
declare(strict_types=1);

namespace RoutesRegistrator\Validation;

interface DataValidatorInterface
{
    public const MODE_STRICT     = 'strict';
    public const MODE_NON_STRICT = 'non_strict';

    public function validate(array $rules, array $data, string $mode = self::MODE_STRICT): ValidationResult;
}