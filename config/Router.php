<?php


namespace App\config;

use App\src\controller\BackController;
use App\src\controller\ErrorController;
use App\src\controller\FrontController;
use Exception;

class Router
{
    /**
     * @var ErrorController
     */
    private $errorController;
    /**
     * @var FrontController
     */
    private $frontController;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var BackController
     */
    private $backController;

    public function __construct()
    {
        $this->request = new Request();
        $this->frontController = new FrontController();
        $this->errorController = new ErrorController();
        $this->backController = new BackController();
    }

    public function startRouter()
    {
        $route = $this->request->getGet()->getParameter('route');

        try {
            if (isset($route)) {
                if ($route === 'register') {
                    $this->frontController->register($this->request->getPost());
                } elseif ($route === 'login') {
                    $this->frontController->login($this->request->getPost());
                } elseif ($route === 'logout') {
                    $this->backController->logout();
                } elseif ($route === 'profil') {
                    $this->backController->profile();
                } elseif ($route === 'articlesManagement') {
                    $this->backController->articlesManagement();
                } elseif ($route === 'updatePassword') {
                    $this->backController->updatePassword($this->request->getPost());
                } elseif ($route === 'updateEmail') {
                    $this->backController->updateEmail($this->request->getPost());
                } elseif ($route === 'deleteAccount') {
                    $this->backController->deleteAccount($this->request->getPost());
                } elseif ($route === 'banOrActiveUser') {
                    $this->backController->banOrActiveUser($this->request->getPost());
                } elseif ($route === 'usersList') {
                    $this->backController->getUsersList();
                } elseif ($route === 'addArticle') {
                    $this->backController->addArticle($this->request->getPost());
                } elseif ($route === 'articlesList') {
                    $this->backController->getArticlesList();
                } elseif ($route === 'singleArticle') {
                    $this->frontController->singleArticle($this->request->getGet());
                } elseif ($route === 'editArticle') {
                    $this->backController->editArticle($this->request->getPost(), $this->request->getGet());
                } elseif ($route === 'deleteArticle') {
                    $this->backController->deleteArticle($this->request->getPost());
                } elseif ($route === 'flagComment') {
                    $this->frontController->flagComment($this->request->getGet());
                } elseif ($route === 'flaggedComment') {
                    $this->backController->getFlaggedComment();
                } elseif ($route === 'moderatedComment') {
                    $this->backController->moderatedComment($this->request->getPost());
                } elseif ($route === 'deleteComment') {
                    $this->backController->deleteComment($this->request->getPost());
                } elseif ($route === 'addComment') {
                    $this->frontController->addComment($this->request->getPost());
                } elseif ($route === 'confirm') {
                    $this->frontController->validateAccount($this->request->getGet());
                } else {
                    $this->errorController->errorNotFound();
                }
            } else {
                $this->frontController->home();
            }
        } catch
        (Exception $e) {
            var_dump($e);
            $this->errorController->errorServer();
        }
    }
}
