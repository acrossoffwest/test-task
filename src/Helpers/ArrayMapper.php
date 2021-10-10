<?php

namespace App\Helpers;

class ArrayMapper
{
    protected array $array = [];

    public function __construct(array $array)
    {
        $this->setArray($array);
    }

    public static function make(array $array): static
    {
        return new static($array);
    }

    public function setArray(array $array)
    {
        $this->array = $array;
    }

    public function get(string $way, $default = null, $delimiter = '.')
    {
        if (preg_match('/\|/', $way)) {
            $items = explode('|', $way);
            foreach ($items as $item) {
                if (is_null($value = $this->get($item, $default, $delimiter))) {
                    continue;
                }
                return $value;
            }
            return $default;
        }

        $wayArray = explode($delimiter, $way);
        $result = null;

        foreach ($wayArray as $key) {
            if (!empty($result)) {
                if (is_array($result) && isset($result[$key])) {
                    $result = $result[$key];
                    continue;
                } elseif (empty($result[$key])) {
                    return $default;
                } else {
                    return empty($result) ? $default : $result;
                }
            }
            if (isset($this->array[$key])) {
                $result = $this->array[$key];
            } else if ($wayArray > 1) {
                return $default;
            }
        }

        return $result === null ? $default : $result;
    }

    public function exists(string $way, $delimiter = '.')
    {
        return !is_null($this->get($way, $delimiter));
    }
}
