<?php


namespace App\src\constraint;

class Validation
{
    public function validate($key, $data, $fieldName)
    {
        if ($key === 'username') {
            $userValidation = new UserValidation();
            return $userValidation->check($data, $fieldName);

        } elseif ($key === 'email') {
            $userValidation = new UserValidation();
            return $userValidation->check($data, $fieldName);

        } elseif ($key === 'password') {
            $userValidation = new UserValidation();
            return $userValidation->check($data, $fieldName);

        } elseif ($key === 'updatepassword') {
            $userValidation = new UserValidation();
            return $userValidation->checkPassword($data, $fieldName);

        } elseif ($key === 'updatemail') {
            $userValidation = new UserValidation();
            return $userValidation->check($data, $fieldName);

        } elseif ($key === 'title' || 'comment') {
            $articleValidation = new ArticleValidation();
            return $articleValidation->check($data, $fieldName);

        } elseif ($key === 'content') {
            $articleValidation = new ArticleValidation();
            return $articleValidation->check($data, $fieldName);
        }
    }
}