<?php

function dnd($data){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();

}


function e($data)
{
    echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}