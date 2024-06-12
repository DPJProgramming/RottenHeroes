<?php
// Colton Matthews 5/12/24
// Most of this is dependent on the home page and will change.

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('controllers/Controller.php');
require_once('model/validate.php');

$path = $_SERVER['DOCUMENT_ROOT'].'/../config.php';
require_once $path;

session_start(); // Start the session

$f3 = Base::instance();


try {
    $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Excsessive error reporting
    $f3->set('DB', $dbh);
} catch (PDOException $e) {
    die("PDO Error: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
$con = new Controller($f3);
$f3->route('GET /', function($f3) {
    $GLOBALS['con']->home();
});

$f3->route('GET /hero/@heroId', function($f3, $params) {
    $f3->set('PARAMS.heroId', $params['heroId']);
    $GLOBALS['con']->hero();
});

$f3->route('POST /submit-comment', function($f3) {
    $GLOBALS['con']->submitComment();
});

$f3->route('GET|POST /login', function($f3) {
    $GLOBALS['con']->login();
});

$f3->route('GET /favorites', function() {
    $GLOBALS['con']->favorites();
});

$f3->route('GET /myAccount', function($f3) {
    $GLOBALS['con']->myAccount();
});

$f3->route('GET|POST /signup', function($f3) {
    $GLOBALS['con']->signUp();
});

$f3->route('POST /blog', function($f3) {
    $GLOBALS['con']->addBlog();
});

$f3->route('POST /rateHeroUp', function($f3) {
    $GLOBALS['con']->rateHeroUp();
});

$f3->route('POST /rateHeroDown', function($f3) {
    $GLOBALS['con']->rateHeroDown();
});

$f3->route('POST /delete-comment', function($f3) {
    $GLOBALS['con']->deleteComment();
});


$f3->route('GET /logout', function($f3) {
    session_destroy();
    $f3->reroute('/');
});

$f3->run();
?>
