<?php

namespace App\Validators;

abstract class AbstractValidator
{
    const DEFAULT_ERROR_MESSAGE = "Try again!";

    /**
     * @param string $input
     * @return bool
     */
    protected function isNumber(string $input): bool
    {
        return is_numeric($input);
    }

    /**
     * @param string $input
     * @return bool
     */
    protected function isGreaterThanZero(string $input): bool
    {
        return $input > 0;
    }

    /**
     * @param string|null $input
     * @return bool
     */
    protected function isRequired(string|null $input): bool
    {
        return $input != null;
    }

    /**
     * @param string $input
     * @param array $supported
     * @return bool
     */
    protected function isIn(string $input, array $supported): bool
    {
        return in_array($input, $supported);
    }
}