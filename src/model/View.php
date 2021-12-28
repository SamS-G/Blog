<?php


namespace App\src\model;

use App\config\Request;

class View
{
    private $title;
    private Request $request;
    private $session;

    public function __construct()
    {
        $this->request = new Request();
        $this->session = $this->request->getSession();
    }

    public function render(string $templateName, array $data = [])
    {
        $file = ROOT . '/templates/' . $templateName . '.php';
        $content = $this->renderFile($file, $data);
        $base = $this->renderFile(ROOT . '/templates/base.php', [
            'content' => $content,
        ]);
        echo $base;
    }

    private function renderFile(string $file, array $data)
    {
        if (file_exists($file)) {
            extract($data);
            ob_start();
            require_once $file;
            return ob_get_clean();
        }
        header('Location: index.php?route=notFound');
    }
}