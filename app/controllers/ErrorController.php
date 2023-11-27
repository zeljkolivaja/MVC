<?php

namespace app\controllers;

use Core\Controller;

class ErrorController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function pageNotFound($message)
    {
        self::logError("404 - Page Not Found: $message");
        $this->renderError('error/pageNotFound', 404, ["message" => $message]);
        exit();
    }

    public function forbidden()
    {
        self::logError("403 - Forbidden");
        $this->renderError('error/forbidden', 403);
        exit();
    }

    private function renderError($view, $statusCode, $data = [])
    {
        http_response_code($statusCode);
        $this->view->render($view, $data);
    }

    public static function logError($message)
    {
        $logFile = ROOT . DS . 'var' . DS . 'errors' . DS  . 'error.log';
        $data = date('Y-m-d H:i:s') . ' - ' . $message;

        // Check if the log file exists
        if (!file_exists($logFile)) {
            // If not, create the directory if it doesn't exist
            $logDirectory = dirname($logFile);
            if (!is_dir($logDirectory)) {
                mkdir($logDirectory, 0777, true);
            }

            // Create the log file
            file_put_contents($logFile, '');
        }

        error_log($data . PHP_EOL, 3, $logFile);
    }
}
