<?php
/**
 * Front controller for the superhero application.
 *
 * PHP version 7.0
 *
 * @category Front_Controller
 * @package  Superhero_Application
 */

// Colton Matthews 5/12/24
// Most of this is dependent on the home page and will change.

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';
require_once 'controllers/Controller.php';
require_once 'model/validate.php';

$path = $_SERVER['DOCUMENT_ROOT'] . '/../config.php';
require_once $path;

session_start(); // Start the session

$f3 = Base::instance();

try {
    $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Excessive error reporting
    $f3->set('DB', $dbh);
} catch (PDOException $e) {
    die("PDO Error: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

$con = new Controller($f3);

$f3->route('GET /', function($f3) {
    /**
     * Home page route.
     *
     * @param Base $f3 The Fat-Free Framework instance.
     */
    $GLOBALS['con']->home();
});

$f3->route('GET /hero/@heroId', function($f3, $params) {
    /**
     * Hero page route.
     *
     * @param Base $f3 The Fat-Free Framework instance.
     * @param array $params Parameters passed in the URL.
     */
    $f3->set('PARAMS.heroId', $params['heroId']);
    $GLOBALS['con']->hero();
});

$f3->route('POST /submit-comment', function($f3) {
    /**
     * Submit comment route.
     *
     * @param Base $f3 The Fat-Free Framework instance.
     */
    $GLOBALS['con']->submitComment();
});

$f3->route('GET|POST /login', function($f3) {
    /**
     * Login route.
     *
     * @param Base $f3 The Fat-Free Framework instance.
     */
    $GLOBALS['con']->login();
});

$f3->route('GET /favorites', function() {
    /**
     * Favorites page route.
     */
    $GLOBALS['con']->favorites();
});

$f3->route('GET /myAccount', function($f3) {
    /**
     * My Account page route.
     *
     * @param Base $f3 The Fat-Free Framework instance.
     */
    $GLOBALS['con']->myAccount();
});

$f3->route('GET|POST /signup', function($f3) {
    /**
     * Signup route.
     *
     * @param Base $f3 The Fat-Free Framework instance.
     */
    $GLOBALS['con']->signUp();
});

$f3->route('POST /blog', function($f3) {
    /**
     * Add blog route.
     *
     * @param Base $f3 The Fat-Free Framework instance.
     */
    $GLOBALS['con']->addBlog();
});

$f3->route('POST /rateHeroUp', function($f3) {
    /**
     * Rate hero up route.
     *
     * @param Base $f3 The Fat-Free Framework instance.
     */
    $GLOBALS['con']->rateHeroUp();
});

$f3->route('POST /rateHeroDown', function($f3) {
    /**
     * Rate hero down route.
     *
     * @param Base $f3 The Fat-Free Framework instance.
     */
    $GLOBALS['con']->rateHeroDown();
});

$f3->route('POST /delete-comment', function($f3) {
    /**
     * Delete comment route.
     *
     * @param Base $f3 The Fat-Free Framework instance.
     */
    $GLOBALS['con']->deleteComment();
});

$f3->route('POST /edit-comment', function($f3) {
    /**
     * Edit comment route.
     *
     * @param Base $f3 The Fat-Free Framework instance.
     */
    $GLOBALS['con']->updateComment();
});

$f3->route('GET /logout', function($f3) {
    /**
     * Logout route.
     *
     * @param Base $f3 The Fat-Free Framework instance.
     */
    session_destroy();
    $f3->reroute('/');
});

$f3->run();
?>
