<?php


namespace App\config;


class Request
{
    public Post $get;
    private Post $post;
    private Session $session;

    public function __construct()
    {
        $this->get = new Post($_GET);
        $this->post = new Post($_POST);
        $this->session = new Session($_SESSION);
    }

    /**
     * @return Post
     */
    public function getGet(): Post
    {
        return $this->get;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }
}