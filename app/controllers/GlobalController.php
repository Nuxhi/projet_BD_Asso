<?php

class GlobalController{
    public function home(){ 
        require_once '../app/views/homePage.php';
    }

    public function notFound(){
        require_once '../app/views/notFound.php';
    }
}