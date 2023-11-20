<?php

class ErrorController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function pageNotFound($message)
    {
        $this->logError("404 - Page Not Found: $message");
        $this->renderError('error/pageNotFound', 404, ["message" => $message]);
        exit();
    }

    public function forbidden()
    {
        $this->logError("403 - Forbidden");
        $this->renderError('error/forbidden', 403);
        exit();
    }

    private function renderError($view, $statusCode, $data = [])
    {
        http_response_code($statusCode);
        $this->view->render($view, $data);
    }

    private function logError($message)
    {
        $logFile = ROOT . DS . 'var' . DS . 'errors' . DS  . 'error.log';
        $data = date('Y-m-d H:i:s') . ' - ' . $message;
        error_log($data . PHP_EOL, 3, $logFile);
    }
}
