<?php

namespace App\DTO;

abstract class DTO
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function toArrayPrefixed(string $prefix): array
    {
        $array = [];

        foreach ($this->toArray() as $key => $value) {
            $array[$prefix . $key] = $value;
        }

        return $array;
    }
}