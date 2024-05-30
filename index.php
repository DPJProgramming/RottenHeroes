<?php
// Colton Matthews 5/12/24
// Most of this is dependent on the home page and will change.

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('controllers/Controller.php');
require_once('model/validate.php'); // Include the Validator class

$f3 = Base::instance();
$con = new Controller($f3);

$f3->route('GET /', function($f3) {
    $GLOBALS['con']->home();
});

$f3->route('GET|POST /login', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Handle login form submission
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

$f3->route('GET /hero', function($f3, $params) {
    $GLOBALS['con']->hero();
});

$f3->route('POST /submit-comment', function($f3) {
    $data = $_POST;
    $errors = Validator::validateComment($data['comment']);

    if (empty($errors)) {
        // Save the comment to the database
        $db = $f3->get('DB');
        $db->exec("INSERT INTO comments (comment, user_id, hero_id) VALUES (?, ?, ?)", [$data['comment'], $_SESSION['user_id'], $data['hero_id']]);
        $f3->reroute('/hero/' . $data['hero_id']);
    } else {
        // Set errors and render the hero page with errors
        $f3->set('errors', $errors);
        // Reload the hero page with errors
        $f3->set('heroId', $data['hero_id']);
        $GLOBALS['con']->hero();
    }
});

$f3->route('GET /home', function($f3) {
    $GLOBALS['con']->home();
});

$f3->run();
