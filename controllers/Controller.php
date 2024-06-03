<?php

class Controller
{
    private $_f3;

    public function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    public function home(): void
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    public function hero(): void
    {
        $db = $this->_f3->get('DB');
        $heroId = $this->_f3->get('PARAMS.heroId');

        // Fetch indo
        $stmt = $db->prepare('SELECT * FROM hero WHERE heroId = :heroId');
        $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
        $stmt->execute();
        $hero = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($hero)) {
            $this->_f3->error(404); // Hero not found
            return;
        }

        // Fetch comments for the hero
        $stmt = $db->prepare('SELECT * FROM comment WHERE heroId = :heroId');
        $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $hero['rating'] = $hero['rating'] ?? 'Not Rated';
        $hero['strength'] = $hero['strength'] ?? 'Unknown';
        $hero['intellect'] = $hero['intellect'] ?? 'Unknown';
        $hero['energy'] = $hero['energy'] ?? 'Unknown';
        $hero['speed'] = $hero['speed'] ?? 'Unknown';
        $hero['powers'] = isset($hero['powers']) ? json_decode($hero['powers'], true) : [];
        // Set variables for the template
        $this->_f3->set('hero', $hero);
        $this->_f3->set('comments', $comments);
        $this->_f3->set('heroId', $heroId);

        $view = new Template();
        echo $view->render('views/hero.html');
    }

    public function submitComment(): void
    {
        $data = $_POST;
        $errors = Validator::validateComment($data['comment']);

        if (empty($errors)) {
            $db = $this->_f3->get('DB');
            $stmt = $db->prepare("INSERT INTO comment (body, userId, heroId, rating, isBlog, created_at) VALUES (:body, :userId, :heroId, :rating, 0, NOW())");
            $stmt->bindParam(':body', $data['comment'], PDO::PARAM_STR);
            $stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':heroId', $data['hero_id'], PDO::PARAM_INT);
            $stmt->bindParam(':rating', 0, PDO::PARAM_INT);
            $stmt->execute();
            $this->_f3->reroute('/hero/' . $data['hero_id']);
        } else {
            $this->_f3->set('errors', $errors);
            $this->_f3->set('heroId', $data['hero_id']);
            $this->hero();
        }
    }

    public function login(): void
    {
        $view = new Template();
        echo $view->render('views/login.html');
    }

    public function signUp(): void
    {
        $view = new Template();
        echo $view->render('views/signUp.html');
    }

    public function favorites(): void
    {
        $view = new Template();
        echo $view->render('views/favorites.html');
    }
}
?>
