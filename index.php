<?php
// Colton Matthews 5/12/24
// Most of this is dependent on the home page and will change.

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('controllers/Controller.php');
require_once('model/validate.php'); // Include the Validator class

$path = $_SERVER['DOCUMENT_ROOT'].'/../config.php';
require_once $path;

$f3 = Base::instance();
$con = new Controller($f3);

try {
    $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions for PDO
    $f3->set('DB', $dbh);
} catch (PDOException $e) {
    die("PDO Error: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

$f3->route('GET /', function($f3) {
    $GLOBALS['con']->home();
});

$f3->route('GET /hero/@heroId', function($f3, $params) {
    $f3->set('PARAMS.heroId', $params['heroId']); //grabs hero id for each hero page
    $GLOBALS['con']->hero();
});

$f3->route('POST /submit-comment', function($f3) {
    $GLOBALS['con']->submitComment();
});

$f3->route('GET|POST /login', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Handle login form submission, still theory
    } else {
        $GLOBALS['con']->login();
    }
});

$f3->route('GET /favorites', function() {
    $GLOBALS['con']->favorites();
});

$f3->route('GET|POST /signup', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Handle sign-up form submission
    } else {
        $GLOBALS['con']->signUp();
    }
});

$f3->route('GET /home', function($f3) {
    $GLOBALS['con']->home();
});

$f3->run();
?>
