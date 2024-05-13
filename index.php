<?php
// Colton Matthews 5/12/24
//Most of this is dependent on the home page and will change.

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once ('vendor/autoload.php');

$f3 = Base::instance();

$f3->route('GET /', function($f3) {
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET|POST /login', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
    } else {
        $view = new Template();
        echo $view->render('views/login.html');
    }
});

$f3->route('GET|POST /signup', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
    } else {
        $view = new Template();
        echo $view->render('views/signUp.html');
    }
});

$f3->route('GET /hero', function($f3, $params) {
    $view = new Template();
    echo $view->render('views/hero.html');
});


$f3->run();
