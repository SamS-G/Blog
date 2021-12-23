<?php

namespace App\src\constraint;

use App\config\Parameter;
use App\src\DAO\UserDAO;

class UserValidation extends Validation
{
    private $constraint;
    private $userDAO;

    public function __construct()
    {
        $this->constraint = new Constraint();
        $this->userDAO = new UserDAO();
    }

    public function check(Parameter $superGlobalData, $fieldName)
    {
        if ($fieldName === 'username') {
            $fieldValue = $superGlobalData->getParameter($fieldName);
            return [
                $fieldName => $this->checkFields($fieldValue),
                $fieldName . 'Duplicate' => $this->checkDuplicateUsername($fieldValue),
            ];
        } elseif ($fieldName === 'email') {
            $fieldValue = $superGlobalData->getParameter($fieldName);
            return [
                $fieldName => $this->checkFields($fieldValue),
                $fieldName . 'Duplicate' => $this->checkDuplicateEmail($fieldValue),
            ];
        } elseif ($fieldName === 'password') {
            $fieldValue = $this->checkPassword($superGlobalData, $fieldName);
            return [
                $fieldName => $fieldValue
            ];
        }
    }

    private function checkFields($value)
    {
        $min = $this->constraint->minLength($value, 6);
        $max = $this->constraint->maxLength($value, 255);
        return ['max' => $max,
            'min' => $min,
        ];
    }

    protected function checkDuplicateUsername($username)
    {
        return $this->userDAO->checkDuplicateUsername($username);
    }


    protected function checkDuplicateEmail($email)
    {
        return $this->userDAO->checkDuplicateEmail($email);
    }


    protected function checkPassword(Parameter $superGlobalData, $password)
    {
        return ['regex' => $this->constraint->regex($superGlobalData->getParameter($password))];
    }
}
