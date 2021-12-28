<?php

namespace App\src\constraint;

use App\config\Post;

class ArticleValidation extends Validation
{
    private $constraint;

    public function __construct()
    {
        $this->constraint = new Constraint();
    }

    public function check(Post $superGlobalData, $fieldName)
    {
        if ($fieldName === 'title' || 'comment') {
            $fieldValue = $superGlobalData->getParameter($fieldName);
            return [
                $fieldName => $this->checkFields($fieldValue)
            ];
        } elseif ($fieldName === 'contents') {
            $fieldValue = $superGlobalData->getParameter($fieldName);
            return [
                $fieldName => $this->checkBlank($fieldValue)
            ];
        }
    }

    private function checkFields($value)
    {
        $blank = $this->constraint->notBlank($value);
        $min = $this->constraint->minLength($value, 6);
        $max = $this->constraint->maxLength($value, 255);
        return ['max' => $max,
            'min' => $min,
            'blank' => $blank
        ];
    }

    private function checkBlank($value)
    {
        $blank = $this->constraint->notBlank($value);
        return ['blank' => $blank];
    }
}
