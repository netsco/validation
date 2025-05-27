<?php

namespace Rakit\Validation\Rules;

use Rakit\Validation\Rule;

class Url extends Rule
{

    /** @var string */
    protected $message = "The :attribute is not valid url";

    /**
     * Given $params and assign $this->params
     *
     * @return self
     */
    public function fillParameters(array $params): Rule
    {
        if (count($params) == 1 && is_array($params[0])) {
            $params = $params[0];
        }

        return $this->forScheme($params);
    }

    /**
     * Given $schemes and assign $this->params
     *
     * @param array $schemes
     * @return self
     */
    public function forScheme($schemes): Rule
    {
        $this->params['schemes'] = (array) $schemes;
        return $this;
    }

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     */
    public function check($value): bool
    {
        $schemes = $this->parameter('schemes');

        if (!$schemes) {
            return $this->validateCommonScheme($value);
        }
        foreach ($schemes as $scheme) {
            $method = 'validate' . ucfirst($scheme) .'Scheme';
            if (method_exists($this, $method)) {
                if ($this->{$method}($value)) {
                    return true;
                }
            } elseif ($this->validateCommonScheme($value, $scheme)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Validate $value is valid URL format
     */
    public function validateBasic(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Validate $value is correct $scheme format
     */
    public function validateCommonScheme(mixed $value, $scheme = null): bool
    {
        if (!$scheme) {
            return $this->validateBasic($value) && (bool) preg_match("/^\w+:\/\//i", $value);
        }
        return $this->validateBasic($value) && (bool) preg_match("/^{$scheme}:\/\//", $value);
    }

    /**
     * Validate the $value is mailto scheme format
     */
    public function validateMailtoScheme(mixed $value): bool
    {
        return $this->validateBasic($value) && preg_match("/^mailto:/", $value);
    }

    /**
     * Validate the $value is jdbc scheme format
     */
    public function validateJdbcScheme(mixed $value): bool
    {
        return (bool) preg_match("/^jdbc:\w+:\/\//", $value);
    }
}
