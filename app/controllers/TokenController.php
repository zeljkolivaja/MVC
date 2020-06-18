<?php

Class TokenController
{


    public function create($userId)
    {

        $tokenModel = new Token;
        $tokenModel->create($userId);
        
    }

    public function regenerate()
    {

        $tokenModel = new Token;
        $tokenModel->regenerate();
        
    }
    


}