<?php

function dnd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}


function e($data)
{
    if (!$data) {
        echo "";
    } else {
        echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}

function message($message = NULL)
{
    if ($message != NULL)
        echo '<div class="alert alert-danger" role="alert">';
    echo $message;
    echo '</div>';
}
