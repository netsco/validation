<?php

namespace Rakit\Validation\Rules;

use Rakit\Validation\Rule;

class DigitsBetween extends Rule
{
    /** @var string */
    protected $message = "The :attribute must have a length between the given :min and :max";

    /** @var array */
    protected $fillableParams = ['min', 'max'];

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     */
    public function check($value): bool
    {
        $this->requireParameters($this->fillableParams);

        $min = (int) $this->parameter('min');
        $max = (int) $this->parameter('max');

        $length = strlen((string) $value);

        return in_array(preg_match('/[^0-9]/', $value), [0, false], true)
                    && $length >= $min && $length <= $max;
    }
}
