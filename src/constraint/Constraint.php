<?php

namespace App\src\constraint;


class Constraint
{
    public function notBlank($value)
    {
        if (empty($value)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function minLength($value, $minSize)
    {
        if (strlen($value) < $minSize) {
            return 1;
        } else {
            return 0;
        }
    }

    public function maxLength($value, $maxSize)
    {
        if (strlen($value) > $maxSize) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @param $value
     * @return int
     * @regex :
     * - min 8 characters and max 20,
     * - include minimum 1 number, 1 letter, 1 uppercase, 1 symbol
     */
    public function regex($value)
    {
        if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $value)) {
            return 0;
        } else {
            return 1;
        }
    }
}