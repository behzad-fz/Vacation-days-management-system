<?php

namespace App\Validators;

use App\Exceptions\InvalidInputException;
use App\Interfaces\ValidatorInterface;

class InputYearValidator extends AbstractValidator implements ValidatorInterface
{
    private string|null $input;

    public function __construct(string|null $input) {
        $this->input = $input;
    }

    /**
     * @return string
     * @throws InvalidInputException
     */
    public function validate(): string
    {
        foreach ($this->rules() as $rule) {
            $method = 'is'.ucfirst($rule);
            if (! $this->$method($this->input)) {
                throw new InvalidInputException($this->messages($rule));
            }
        }

        return $this->input;
    }

    /**
     * @return string[]
     */
    private function rules(): array
    {
        return ['required', 'number', 'greaterThanZero'];
    }

    /**
     * @param $rule
     * @return string
     */
    private function messages($rule): string
    {
        $messages = [
            'required' => "Enter your desire year.",
            'number' => "Enter a valid number.",
            'greaterThanZero' => "Enter a number greater than zero."
        ];

        return $messages[$rule] ?? self::DEFAULT_ERROR_MESSAGE;
    }
}