<?php

class View
{

    protected $_head, $_body, $_siteTitle = SITE_TITLE, $_outputBuffer, $_layout = DEFAULT_LAYOUT;

    public function __construct()
    {
    }

    public function render($viewName, $data = [])
    {
        $viewArry = explode('/', $viewName);
        $viewString = implode(DS, $viewArry);
        extract($data);

        if (file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php')) {
            include ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php';
            include ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php';
        } else {
            $error = new ErrorController;
            $error->pageNotFound($viewName);
        }
    }

    //content is called from layout, it gets conttent of _head or _body, in those properties we store
    // content which we want to display (we save it there using the start/end methods which we call from some view)
    public function content($type)
    {
        if ($type == 'head') {
            return $this->_head;
        } elseif ($type == 'body') {
            return $this->_body;
        } else {
            return 'false';
        }
    }

    //records to buffer and sets the __outputBuffer property to head or body state
    public function start($type)
    {
        // we store the head or body in _outputBuffer
        $this->_outputBuffer = $type;

        ob_start();

    }

    //checks the currents state of _outputBuffer(set in start method) and saves the generated content using the
    //ob_get_clean in body or head property so we can display it in layout
    public function end()
    {
        if ($this->_outputBuffer == 'head') {
            $this->_head = ob_get_clean();
        } elseif ($this->_outputBuffer == 'body') {
            $this->_body = ob_get_clean();

        } else {
            die('You must first run start function');
        }
    }

    //we use this to set site title in different pages
    public function setSiteTitle($title)
    {
        $this->_siteTitle = $title;
    }

    //change the layout (if not set we use the DEFAULT_LAYOUT from config)
    public function setLayout($path)
    {
        $this->_layout = $path;
    }
}