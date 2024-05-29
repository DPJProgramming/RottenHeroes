<?php

class Controller
{
    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function hero()
    {
        $view = new Template();
        echo $view->render('views/hero.html');
    }

    function login()
    {
        $view = new Template();
        echo $view->render('views/login.html');
    }

    function signUp()
    {
        $view = new Template();
        echo $view->render('views/signUp.html');
    }

    function favorites()
    {
        $view = new Template();
        echo $view->render('views/favorites.html');
    }
}
