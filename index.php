<?php

//for error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

$f3 = Base::instance();

$f3->route('GET /', function() {
    //echo '<h1>test test</h1>';

    $view = new Template();
    echo $view->render('views/home.html');
});


// Log-in
$f3->route('GET /views/login', function() {
    //echo '<h1>My Breakfast Menu</h1>';

    // Render a view page
    $view = new Template();
    echo $view->render('views/login.html');
});