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
        $view = new Template();
        echo $view->render('views/home.html');
    }

    public function hero(): void
    {
        $db = $this->_f3->get('DB');
        $heroId = $this->_f3->get('PARAMS.heroId');

        // Fetch indo
        $stmt = $db->prepare('SELECT * FROM hero WHERE userId = :heroId');
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

        //fetch blog for hero
        $stmt = $db->prepare('SELECT * FROM comment WHERE userId = :heroId AND isBlog = TRUE');
        $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
        $stmt->execute();
        $blog = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $hero['rating'] = $hero['rating'] ?? 'Not Rated';
        $hero['strength'] = $hero['strength'] ?? 'Unknown';
        $hero['intellect'] = $hero['intellect'] ?? 'Unknown';
        $hero['energy'] = $hero['energy'] ?? 'Unknown';
        $hero['speed'] = $hero['speed'] ?? 'Unknown';
        $hero['powers'] = $hero['powers'] ?? 'none';
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
        $errors = Validator::validateComment($data['comment']);

        //temp to add user to comment
        $randomNumber = rand(1, 10);
        $stmt = $db->prepare('SELECT name FROM user WHERE userId = :heroId');
        $stmt->bindParam(':heroId', $randomNumber, PDO::PARAM_INT);
        $stmt->execute();
        $userName = $stmt->fetchColumn();


        if (empty($errors)) {
            $db = $this->_f3->get('DB');
            $stmt = $db->prepare("INSERT INTO comment (body, userId, userName, heroId, rating, isBlog, created_at) 
                                VALUES (:body, :userId, :userName, :heroId, 0, 0, NOW())");
            $stmt->bindParam(':body', $data['comment'], PDO::PARAM_STR);
            $stmt->bindParam(':userId', $randomNumber, PDO::PARAM_INT); //$_SESSION['user_id']
            $stmt->bindParam(':userName', $userName);
            $stmt->bindParam(':heroId', $data['hero_id'], PDO::PARAM_INT);
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

    function addBlog(){
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

//
//        //validate and make sure appropriate hero/admin is commenting
//        //if(logged in id == id of hero page hero)
//
        //add to database
        $stmt = $db->prepare("INSERT INTO comment (body, userId, heroId, userName, rating, isBlog, created_at) 
                          VALUES (:body, :userId, :heroId, :userName, :rating, :isBlog, :created_at)");
        $stmt->bindParam(':body', $blog->getBody());
        $stmt->bindParam(':userId', $blog->getUserId());
        $stmt->bindParam(':heroId', $blog->getHeroPage());
        $stmt->bindParam(':userName', $blog->getUserName());
        $stmt->bindParam(':rating', $blog->getRating());
        $stmt->bindParam(':isBlog', $blog->getIsBlog());
        $stmt->bindParam(':created_at', $blog->getDate());
        $stmt->execute();

        // Refresh the page
        $this->_f3->reroute('/hero/' . $blog->getHeroPage());
    }
}
?>
