<?php


namespace App\src\model;

use App\config\Request;

class View
{
    private $title;
    private $file;
    private $request;
    private $session;

    public function __construct()
    {
        $this->request = new Request();
        $this->session = $this->request->getSession();
    }

    public function render($templateName, $data = [])
    {
        $this->file = '../templates/' . $templateName . '.php';
        $content = $this->renderFile($this->file, $data);
        $view = $this->renderFile('../templates/base.php', [
            'content' => $content,
        ]);
        echo $view;
    }

    private function renderFile($file, $data)
    {
        if (file_exists($file)) {
            extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        }
        header('Location: index.php?route=notFound');
    }
}