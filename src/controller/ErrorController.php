<?php

namespace App\src\controller;

class ErrorController extends Controller
{
    /**
     * @return void
     */
    public function errorNotFound()
    {
        return $this->view->render('error_404');
    }

    /**
     * @return void
     */
    public function errorServer()
    {
        return $this->view->render('error_500');
    }
}