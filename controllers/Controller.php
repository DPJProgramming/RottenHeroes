<?php

use classes\Comment;

class Controller
{
    private $_f3;

    public function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    public function home(): void
    {
        $db = $this->_f3->get('DB');

        // pulls each hero from the database and slots it into the home page card. -CM
        $stmt = $db->prepare('SELECT * FROM hero ORDER BY rating DESC LIMIT 7');
        $stmt->execute();
        $topHeroes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $db->prepare('SELECT * FROM hero ORDER BY rating ASC LIMIT 3');
        $stmt->execute();
        $worstHeroes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->_f3->set('topHeroes', $topHeroes);
        $this->_f3->set('worstHeroes', $worstHeroes);

        $view = new Template();
        echo $view->render('views/home.html');
    }

    public function hero(): void
    {
        $db = $this->_f3->get('DB');
        $heroId = $this->_f3->get('PARAMS.heroId');

        // Fetch hero information
        $stmt = $db->prepare('SELECT * FROM hero WHERE heroId = :heroId');
        $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
        $stmt->execute();
        $hero = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($hero)) {
            $this->_f3->error(404); // Hero not found
            return;
        }

        // Fetch comments for the hero
        $stmt = $db->prepare('SELECT * FROM comment WHERE heroId = :heroId AND isBlog = FALSE');
        $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch blog for hero
        $stmt = $db->prepare('SELECT * FROM comment WHERE heroId = :heroId AND isBlog = TRUE');
        $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
        $stmt->execute();
        $blog = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Set variables for the template
        $this->_f3->set('hero', $hero);
        $this->_f3->set('comments', $comments);
        $this->_f3->set('heroId', $heroId);
        $this->_f3->set('blog', $blog);

        $view = new Template();
        echo $view->render('views/hero.html');
    }

    public function submitComment(): void
    {
        $db = $this->_f3->get('DB');
        $data = $_POST;

        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            $this->_f3->set('errors', ['comment' => 'You must be logged in to comment.']);
            $this->_f3->set('heroId', $data['hero_id']);
            $this->hero();
            return;
        }

        // Fetch the username based on the user ID from the session
        $stmt = $db->prepare('SELECT name FROM user WHERE userId = :userId');
        $stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $userName = $stmt->fetchColumn();

        if (!$userName) {
            $this->_f3->set('errors', ['comment' => 'User not found.']);
            $this->_f3->set('heroId', $data['hero_id']);
            $this->hero();
            return;
        }

        // Insert the comment into the database
        $stmt = $db->prepare("INSERT INTO comment (body, userId, userName, heroId, rating, isBlog, created_at) 
                        VALUES (:body, :userId, :userName, :heroId, 0, 0, NOW())");
        $stmt->bindParam(':body', $data['comment'], PDO::PARAM_STR);
        $stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':heroId', $data['hero_id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            error_log('Comment successfully submitted');
            $this->_f3->reroute('/hero/' . $data['hero_id']);
        } else {
            // Detailed error logging
            error_log('Failed to execute statement: ' . print_r($stmt->errorInfo(), true));
            $this->_f3->set('errors', ['comment' => 'Failed to submit comment.']);
            $this->_f3->set('heroId', $data['hero_id']);
            $this->hero();
        }
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $db = $this->_f3->get('DB');
            $data = $_POST;

            // Log the received POST data for debugging
            error_log('Received POST data: ' . print_r($data, true));

            // Validate and authenticate user credentials
            $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Log the user fetched from the database
            error_log('User fetched from DB: ' . print_r($user, true));

            if ($user && password_verify($data['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['userId'];
                $_SESSION['user_name'] = $user['name'];
                error_log('Login successful. Redirecting to home.');
                $this->_f3->reroute('/');
            } else {
                error_log('Invalid email or password');
                $this->_f3->set('login_error', 'Invalid email or password');
                $view = new Template();
                echo $view->render('views/login.html');
            }
        } else {
            $view = new Template();
            echo $view->render('views/login.html');
        }
    }

    public function signUp(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $db = $this->_f3->get('DB');
            $data = $_POST;

            // Hash the password before storing it
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            // Insert into user table
            $stmt = $db->prepare("INSERT INTO user (name, email, password, isAdmin) VALUES (:name, :email, :password, 0)");
            $stmt->bindParam(':name', $data['real_name'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->execute();
            $userId = $db->lastInsertId();

            // If hero checkbox is checked, insert into hero table
            if (isset($data['isHero'])) {
                $stmt = $db->prepare("INSERT INTO hero (hero_name, real_name, rating, strength, intellect, energy, speed, powers, image, userId) 
                                      VALUES (:hero_name, :real_name, :rating, :strength, :intellect, :energy, :speed, :powers, :image, :userId)");
                $stmt->bindParam(':hero_name', $data['hero_name'], PDO::PARAM_STR);
                $stmt->bindParam(':real_name', $data['real_name'], PDO::PARAM_STR);
                $stmt->bindParam(':rating', $data['rating'], PDO::PARAM_INT);
                $stmt->bindParam(':strength', $data['strength'], PDO::PARAM_INT);
                $stmt->bindParam(':intellect', $data['intellect'], PDO::PARAM_INT);
                $stmt->bindParam(':energy', $data['energy'], PDO::PARAM_INT);
                $stmt->bindParam(':speed', $data['speed'], PDO::PARAM_INT);
                $stmt->bindParam(':powers', $data['powers'], PDO::PARAM_STR);
                $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->execute();
            }

            $this->_f3->reroute('/login');
        } else {
            $view = new Template();
            echo $view->render('views/signUp.html');
        }
    }

    public function favorites(): void
    {
        $view = new Template();
        echo $view->render('views/favorites.html');
    }

    public function addBlog(): void
    {
        $db = $this->_f3->get('DB');

        // Instantiate comment object
        $blog = new Comment($_POST['blog']);
        $blog->setIsBlog(true);
        $blog->setHeroPage($_POST['hero_id']);

        // Fetch the username based on the hero ID
        $stmt = $db->prepare('SELECT name FROM user WHERE userId = :heroId');
        $stmt->bindParam(':heroId', $blog->getHeroPage(), PDO::PARAM_INT);
        $stmt->execute();
        $userName = $stmt->fetchColumn();
        $blog->setUserName($userName);
        $blog->setUserId($blog->getHeroPage());

        // Add to database
        $stmt = $db->prepare("INSERT INTO comment (body, userId, heroId, userName, rating, isBlog, created_at) 
                          VALUES (:body, :userId, :heroId, :userName, :rating, :isBlog, :created_at)");
        $stmt->bindParam(':body', $blog->getBody(), PDO::PARAM_STR);
        $stmt->bindParam(':userId', $blog->getUserId(), PDO::PARAM_INT);
        $stmt->bindParam(':heroId', $blog->getHeroPage(), PDO::PARAM_INT);
        $stmt->bindParam(':userName', $blog->getUserName(), PDO::PARAM_STR);
        $stmt->bindParam(':rating', $blog->getRating(), PDO::PARAM_INT);
        $stmt->bindParam(':isBlog', $blog->getIsBlog(), PDO::PARAM_INT);
        $stmt->bindParam(':created_at', $blog->getDate(), PDO::PARAM_STR);
        $stmt->execute();

        // Refresh the page
        $this->_f3->reroute('/hero/' . $blog->getHeroPage());
    }
}
?>
