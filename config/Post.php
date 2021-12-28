<?php


namespace App\config;

class Post
{
    /**
     * @var array
     */
    private array $post;

    /**
     * @param $post
     */
    public function __construct($post)
    {
        $this->post = $post;

    }

    public function getPostParam($name)
    {
        if (isset($this->post[$name]))
        {
            return $this->post[$name];
        }
    }

    public function setPostParam($name, $value)
    {
        $this->post[$name] = $value;
    }

    public function all(): array
    {
        return $this->post;
    }
}