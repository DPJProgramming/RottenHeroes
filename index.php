<?php
// Colton Matthews 5/12/24
//Most of this is dependent on the home page and will change.

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('controllers/Controller.php');

$f3 = Base::instance();
$con = new Controller($f3);

$f3->route('GET /', function($f3) {
    $GLOBALS['con']->home();
});

$f3->route('GET|POST /login', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
    } else {
        $GLOBALS['con']->login();
    }
});

$f3->route('GET /favorites', function() {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
    } else {
        $GLOBALS['con']->favorites();
    }
});


$f3->route('GET|POST /signup', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
    } else {
        $GLOBALS['con']->signUp();
    }
});

$f3->route('GET /hero', function($f3, $params) {
    $GLOBALS['con']->hero();
});

$f3->route('GET /home', function($f3) {
    $GLOBALS['con']->home();
});

$f3->run();
