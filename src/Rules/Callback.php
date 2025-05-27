<?php

namespace Rakit\Validation\Rules;

use Exception;
use Rakit\Validation\Rule;
use InvalidArgumentException;
use Closure;

class Callback extends Rule
{
    /** @var string */
    protected $message = "The :attribute is not valid";

    /** @var array */
    protected $fillableParams = ['callback'];

    /**
     * Set the Callback closure
     *
     * @return self
     */
    public function setCallback(Closure $callback): Rule
    {
        return $this->setParameter('callback', $callback);
    }

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @throws Exception
     */
    public function check($value): bool
    {
        $this->requireParameters($this->fillableParams);

        $callback = $this->parameter('callback');
        if (false === $callback instanceof Closure) {
            $key = $this->attribute->getKey();
            throw new InvalidArgumentException("Callback rule for '{$key}' is not callable.");
        }

        $callback = $callback->bindTo($this);
        $invalidMessage = $callback($value);

        if (is_string($invalidMessage)) {
            $this->setMessage($invalidMessage);
            return false;
        }

        return false !== $invalidMessage;
    }
}
