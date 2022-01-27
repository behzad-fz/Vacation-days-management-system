<?php

namespace App\Validators;

use App\Exceptions\InvalidFilePathException;
use App\Exceptions\InvalidInputException;
use App\Interfaces\ValidatorInterface;

class OutputValidator extends AbstractValidator implements ValidatorInterface
{
    private string|null $input;

    public function __construct(string|null $input) {
        $this->input = $input;
    }

    /**
     * @return array
     * @throws InvalidInputException
     */
    public function validate(): array
    {
        if ($this->input === null) {
            return ['console'];
        }

        foreach ($this->rules() as $rule) {
            $explode = explode(':', $rule);
            $method = 'is'.ucfirst($explode[0]);

            if (! $this->$method($this->getEnteredFormat(), json_decode($explode[1]) ?? null)) {
                throw new InvalidInputException($this->messages($explode[0]));
            }
        }

        return [$this->getEnteredFormat(), $this->getFilePath()];
    }

    /**
     * @return string[]
     */
    private function rules(): array
    {
        return ['in:["console", "json", "txt"]'];
    }

    /**
     * @param $rule
     * @return string
     */
    private function messages($rule): string
    {
        $messages = [
            'in' => "The input does not exist in the supported options.",
        ];

        return $messages[$rule] ?? self::DEFAULT_ERROR_MESSAGE;
    }

    /**
     * @return string
     */
    private function getEnteredFormat(): string
    {
        $start = strpos($this->input, '-',2);
        $end = strpos($this->input, '=');

        return substr($this->input,$start+1, $end ? ($end - $start) - 1 : $start + 100);
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function getFilePath(): string
    {
        $start = strpos($this->input, '=');

        $path = substr($this->input,$start+1);

        $explode = explode('.', $path);

        if (count($explode) < 2) {
            throw new InvalidFilePathException();
        }

        $path = str_replace($explode[1],$this->getEnteredFormat(),$path);

        return $path;
    }
}