<?php

namespace App\src\controller;

use App\config\Post;
use App\config\Request;
use App\config\Session;
use App\src\DAO\ArticleDAO;
use App\src\DAO\CommentDAO;
use App\src\DAO\UserDAO;
use App\src\model\View;

abstract class Controller
{
    protected UserDAO $userDAO;
    protected ArticleDAO $articleDAO;
    protected CommentDAO $commentDAO;
    protected Request $request;
    protected View $view;
    protected Post $get;
    protected Post $post;
    protected Session $session;


    public function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
        $this->request = new Request();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
    }
}