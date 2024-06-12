<?php

use classes\Comment;
use classes\Hero;

/**
 * Controller class for handling application logic.
 */
class Controller
{
    /** @var object The Fat-Free Framework instance. */
    private $_f3;

    /**
     * Constructor.
     *
     * @param object $f3 The Fat-Free Framework instance.
     */
    public function __construct($f3)
    {
        $this->_f3 = $f3;

        $db = $f3->get('DB');

        if (!$db) {
            die('Database connection is null');
        }

        $this->heroModel = new HeroDataLayer($db);
        $this->userModel = new UserDataLayer($db);
        $this->commentBlogModel = new CommentBlogDataLayer($db);
    }

    /**
     * Displays the home page.
     */
    public function home(): void
    {
        $topHeroes = $this->heroModel->getTopHeroes();
        $worstHeroes = $this->heroModel->getWorstHeroes();

        $this->_f3->set('topHeroes', $topHeroes);
        $this->_f3->set('worstHeroes', $worstHeroes);

        $view = new Template();
        echo $view->render('views/home.html');
    }

    /**
     * Displays hero details page.
     */
    public function hero(): void
    {
        session_start();
        $db = $this->_f3->get('DB');
        $heroId = $this->_f3->get('PARAMS.heroId');
        $userId = $_SESSION['user_id'] ?? null;

        $hero = $this->heroModel->getHeroById($heroId);
        if (empty($hero)) {
            $this->_f3->error(404);
            return;
        }

        $comments = $this->commentBlogModel->getCommentsByHeroId($heroId, false);
        $blog = $this->commentBlogModel->getCommentsByHeroId($heroId, true);

        $isHero = ($userId !== null && $userId == $hero['userId']);

        // Set variables for the template
        $this->_f3->set('hero', $hero);
        $this->_f3->set('comments', $comments);
        $this->_f3->set('heroId', $heroId);
        $this->_f3->set('blog', $blog);
        $this->_f3->set('isHero', $isHero);

        $view = new Template();
        echo $view->render('views/hero.html');
    }

    /**
     * Handles submission of comments.
     */
    public function submitComment(): void
    {
        $db = $this->_f3->get('DB');
        $data = $_POST;

        if (!isset($_SESSION['user_id'])) {
            $this->_f3->set('errors', ['comment' => 'You must be logged in to comment.']);
            $this->_f3->set('heroId', $data['hero_id']);
            $this->hero();
            return;
        }

        $user = $this->userModel->getUserById($_SESSION['user_id']);
        if (!$user) {
            $this->_f3->set('errors', ['comment' => 'User not found.']);
            $this->_f3->set('heroId', $data['hero_id']);
            $this->hero();
            return;
        }

        $commentData = [
            'body' => $data['comment'],
            'userId' => $_SESSION['user_id'],
            'userName' => $user['name'],
            'heroId' => $data['hero_id'],
            'rating' => 0,
            'isBlog' => false
        ];
        $this->commentBlogModel->createComment($commentData);
        $this->_f3->reroute('/hero/' . $data['hero_id']);
    }

    /**
     * Handles user login.
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $db = $this->_f3->get('DB');
            $data = $_POST;
            $user = $this->userModel->getUserByEmail($data['email']);

            if ($user && password_verify($data['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['userId'];
                $_SESSION['user_name'] = $user['name'];
                error_log('Login successful. Redirecting to home.');
                $this->_f3->reroute('/');
            } else {
                $this->_f3->set('login_error', 'Invalid email or password');
                $view = new Template();
                echo $view->render('views/login.html');
            }
        } else {
            $view = new Template();
            echo $view->render('views/login.html');
        }
    }

    /**
     * Handles user sign up.
     */
    public function signUp(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $db = $this->_f3->get('DB');
            $data = $_POST;

            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $userId = $this->userModel->createUser($data['real_name'], $data['email'], $hashedPassword);

            $imageFileName = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $target_dir = "img/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);

                // Handle image upload
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $imageFileName = basename($_FILES["image"]["name"]);
                    error_log('Image filename error: ' . $imageFileName);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

            if (isset($data['isHero'])) {
                $heroData = [
                    'hero_name' => $data['hero_name'],
                    'real_name' => $data['real_name'],
                    'strength' => $data['strength'],
                    'intellect' => $data['intellect'],
                    'energy' => $data['energy'],
                    'speed' => $data['speed'],
                    'powers' => $data['powers'],
                    'image' => $imageFileName,
                    'userId' => $userId
                ];
                $this->heroModel->createHero($heroData);
            }

            $this->_f3->reroute('/login');
        } else {
            $view = new Template();
            echo $view->render('views/signUp.html');
        }
    }

    /**
     * Displays user favorites page.
     */
    public function favorites(): void
    {
        $view = new Template();
        echo $view->render('views/favorites.html');
    }

    /**
     * Displays user account details.
     */
    public function myAccount(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            $this->_f3->set('SESSION.redirect_message', 'Please sign in first');
            $this->_f3->reroute('/login');
            return;
        }
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);
        $this->_f3->set('user', $user);

        $hero = $this->heroModel->getHeroByUserId($userId);
        if ($hero) {
            $this->_f3->set('hero', $hero);

            $blogPosts = $this->commentBlogModel->getCommentsByHeroId($hero['heroId'], true);
            $this->_f3->set('blogPosts', $blogPosts);
        } else {
            $this->_f3->clear('hero');
            $this->_f3->clear('blogPosts');
        }

        $comments = $this->commentBlogModel->getCommentsByUserId($userId);
        $this->_f3->set('comments', $comments);

        $view = new Template();
        echo $view->render('views/myAccount.html');
    }

    /**
     * Handles adding a blog post.
     */
    public function addBlog(): void
    {
        $data = $_POST;

        $blog = new Comment($this->_f3->get('DB'));
        $blog->setBody($data['blog']);
        $blog->setIsBlog(true);
        $blog->setHeroPage($data['hero_id']);
        $blog->setUserId($data['hero_id']);

        $hero = $this->heroModel->getHeroByUserId($_SESSION['user_id'])['hero_name'];
        $blog->setUserName($hero);

        $blogData = [
            'body' => $blog->getBody(),
            'userId' => $blog->getUserId(),
            'userName' => $blog->getUserName(),
            'heroId' => $blog->getHeroPage(),
            'rating' => 0,
            'isBlog' => $blog->getIsBlog(),
            'created_at' => $blog->getDate()
        ];
        $this->commentBlogModel->createComment($blogData);

        $this->_f3->reroute('/hero/' . $blog->getHeroPage());
    }
    /**
     * Handles rating a hero up.
     */
    public function rateHeroUp(): void
    {
        $heroId = $_POST['hero_id'];
        $this->heroModel->rateHeroUp($heroId);
        $this->_f3->reroute('/hero/' . $heroId);
    }

    /**
     * Handles rating a hero down.
     */
    public function rateHeroDown(): void
    {
        $heroId = $_POST['hero_id'];
        $this->heroModel->rateHeroDown($heroId);
        $this->_f3->reroute('/hero/' . $heroId);
    }

    /**
     * Deletes a comment.
     */
    public function deleteComment(): void
    {
        $db = $this->_f3->get('DB');
        $data = $_POST;

        if (!isset($_SESSION['user_id'])) {
            $this->_f3->set('errors', ['comment' => 'You must be logged in to delete a comment.']);
            $this->_f3->reroute('/hero/' . $data['hero_id']);
            return;
        }

        $commentId = $data['comment_id'];
        $userId = $_SESSION['user_id'];

        $this->commentBlogModel->deleteComment($commentId, $userId);

        $this->_f3->reroute('/hero/' . $data['hero_id']);
    }

    /**
     * Updates a comment.
     */
    public function updateComment(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $commentId = $_POST['comment_id'];
            $newBody = $_POST['comment'];

            if (!isset($_SESSION['user_id'])) {
                $this->_f3->set('errors', ['comment' => 'You must be logged in to edit a comment.']);
                $this->_f3->reroute('/hero/' . $_POST['hero_id']);
                return;
            }

            $commentData = [
                'body' => $newBody,
                'comment_id' => $commentId
            ];
            $this->commentBlogModel->updateComment($commentData);
            $this->_f3->reroute('/hero/' . $_POST['hero_id']);
        } else {
            $this->_f3->error(404);
        }
    }

}

?>
