<?php


namespace App\config;

class Parameter
{
    /**
     * @var array
     */
    private $superglobal;

    /**
     * @param $superglobal
     */
    public function __construct($superglobal)
    {
        $this->superglobal = $superglobal;

    }

    public function getParameter($name)
    {
        if (isset($this->superglobal[$name]))
        {
            return $this->superglobal[$name];
        }
    }

    public function setParameter($name, $value)
    {
        $this->superglobal[$name] = $value;
    }

    public function all()
    {
        return $this->superglobal;
    }
}