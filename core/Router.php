<?php

class Router
{

    public static function route($url)
    {

        //the first string in the $url array will be our controller, we assign it to the $controller variable
        //if the $url[0] is empty we providte it with DEFAULT_CONTROLLER value stored in config
        //then using the array_shift we remove the firts field(controller) from $url array
        if (isset($url[0]) && $url[0] != '') {
            $controller = ucwords($url[0] . "Controller");
        } else {
            $controller = DEFAULT_CONTROLLER;
        }
        array_shift($url);

        // in the last step we removed the controller from $url[0]
        // so now we can use the same process to extract the method which should be at $Url[0] position
        // if its not defined we define it to be index, and using array_shift its removed from array

        if (isset($url[0]) && $url[0] != '') {
            $action = $url[0];
        } else {
            $action = 'index';
        }
        array_shift($url);

        //the only thing left in $url array should be the parameters user passed to us, so we save them in $query_params
        $query_params = $url;

        //now we instantiate the extracted controller, if its not found we throw an error

        if (class_exists($controller)) {
            $dispatch = new $controller();
        } else {
            $error = new ErrorController;
            $error->pageNotFound($controller);
        }

        //we check does the wanted method exists in defined controller
        //if nothing found we kill the page
        if (method_exists($controller, $action)) {
            call_user_func_array([$dispatch, $action], $query_params);
        } else {
            $error = new ErrorController;
            $error->pageNotFound($controller);
        }
    }

    //redirect function that checks if the headers are sent, if they are we use javascript to route the user to the
    //requested page (the url doesnt change if the headers are sent, check for better solution?),
    //otherwise we use php function header()
    public static function redirect($url)
    {
        if (headers_sent()) {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . PROOT, $url . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $url . '"/>';
            echo '</noscript>';
        } else {

            header("Location: " . PROOT . $url);
        }

    }

}