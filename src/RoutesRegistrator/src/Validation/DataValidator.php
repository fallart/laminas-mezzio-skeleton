<?php
declare(strict_types=1);

namespace RoutesRegistrator\Validation;

use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputInterface;

class DataValidator implements DataValidatorInterface
{
    /** @var InputFilter */
    private $inputFilter;

    public function __construct()
    {
        $this->inputFilter = new InputFilter();
    }

    private function init(array $rules, array $data): void
    {
        foreach ($rules as $name => $rule) {
            $this->inputFilter->add($rule, $name);
        }
        $this->inputFilter->setData($data);
    }

    public function validate(array $rules, array $data, string $mode = self::MODE_STRICT): ValidationResult
    {
        $this->init($rules, $data);

        return new ValidationResult(
            $this->inputFilter->isValid(),
            $this->getValues($mode),
            $this->inputFilter->getMessages()
        );
    }

    private function getValues(string $mode): array
    {
        $data = [];

        /** @var InputInterface[] $vi */
        $validInputs = $this->inputFilter->getValidInput();
        foreach ($validInputs as $value) {
            $data[$value->getName()] = $value->getValue();
        }

        if ($mode === self::MODE_NON_STRICT) {
            $data = array_merge($data, $this->inputFilter->getUnknown());
        }

        return $data;
    }
}