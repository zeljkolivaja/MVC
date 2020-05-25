<?php

class Router{


 public static function route($url){


    // izvlacimo controller iz querya ($url array), on je uvijek na [0] poziciji
    // ako controller nije definiran postavljamo defaultni (u configu imamo definiranu konstantu)

    if( isset($url[0]) && $url[0] != '')  {
        $controller = ucwords($url[0]);
    }else {
        $controller = DEFAULT_CONTROLLER;
    }
    $controller_name = $controller;
    array_shift($url);

    //kada smo iz querya izvukli controller pomocu metode array_shift izbacujemo ga iz url.a
    // te je sada na poziciji [0] u $url arrayu metoda/akcija koju korisnik zeli izvrsiti
    // izvlacimo je iz $url.a na isti nacin kao i controller

    if( isset($url[0]) && $url[0] != '')  {
        $action = $url[0] . 'Action';
    }else {
        $action = 'indexAction';
    }
    $action_name = $action;
    array_shift($url);

    //nakon sto smo iz $url arraya (nalazi se na index.php) izvukli zeljeni controller i akciju
    //ostaju nam parametri koje je korisnik poslao

    $query_params = $url;
    
    
    //instanciramo objekt 
     $dispatch = new $controller($controller_name, $action);
    

    // umjesto da manualno instanciramo objekt i definiramo mu akciju i saljemo parametre npr.
    // $dispatch->$action_name($query_params)
    //koristimo call_user_func_array metodu
    if ( method_exists($controller, $action) ) {
        call_user_func_array([$dispatch, $action], $query_params);
    }else {
        die('that method doess not exists in the controller' . $controller_name);
    }


 }

}