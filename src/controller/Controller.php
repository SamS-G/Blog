<?php

namespace App\src\controller;

use App\config\Request;
use App\src\constraint\Validation;
use App\src\DAO\ArticleDAO;
use App\src\DAO\CommentDAO;
use App\src\DAO\UserDAO;
use App\src\model\View;

abstract class Controller
{
    protected $userDAO;
    protected  $articleDAO;
    protected $commentDAO;
    protected $request;
    protected $view;
    protected $get;
    protected $post;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();

        $this->view = new View();
        $this->validation = new Validation();

        $this->request = new Request();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
    }
}