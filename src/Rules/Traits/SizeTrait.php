<?php

namespace Rakit\Validation\Rules\Traits;

use InvalidArgumentException;

trait SizeTrait
{

    /**
     * Get size (int) value from given $value
     *
     * @param int|string $value
     * @return float|false
     */
    protected function getValueSize($value): float|false
    {
        if ($this->getAttribute()
            && ($this->getAttribute()->hasRule('numeric') || $this->getAttribute()->hasRule('integer'))
            && is_numeric($value)
        ) {
            $value = (float) $value;
        }

        if (is_int($value) || is_float($value)) {
            return (float) $value;
        }

        if (is_string($value)) {
            return (float) mb_strlen($value, 'UTF-8');
        }

        if ($this->isUploadedFileValue($value)) {
            return (float) $value['size'];
        }

        if (is_array($value)) {
            return (float) count($value);
        }
        return false;
    }

    /**
     * Given $size and get the bytes
     *
     * @param string|int $size
     * @throws InvalidArgumentException
     */
    protected function getBytesSize($size): float
    {
        if (is_numeric($size)) {
            return (float) $size;
        }

        if (!is_string($size)) {
            throw new InvalidArgumentException("Size must be string or numeric Bytes", 1);
        }

        if (in_array(preg_match("/^(?<number>((\d+)?\.)?\d+)(?<format>(B|K|M|G|T|P)B?)?$/i", $size, $match), [0, false], true)) {
            throw new InvalidArgumentException("Size is not valid format", 1);
        }

        $number = (float) $match['number'];
        $format = $match['format'] ?? '';

        return match (strtoupper($format)) {
            "KB", "K" => $number * 1024,
            "MB", "M" => $number * 1024 ** 2,
            "GB", "G" => $number * 1024 ** 3,
            "TB", "T" => $number * 1024 ** 4,
            "PB", "P" => $number * 1024 ** 5,
            default => $number,
        };
    }

    /**
     * Check whether value is from $_FILES
     */
    public function isUploadedFileValue(mixed $value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        $keys = ['name', 'type', 'tmp_name', 'size', 'error'];
        foreach ($keys as $key) {
            if (!array_key_exists($key, $value)) {
                return false;
            }
        }

        return true;
    }
}
