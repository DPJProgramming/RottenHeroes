<?php
class HeroDataLayer
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getTopHeroes()
    {
        $stmt = $this->db->prepare('SELECT * FROM hero ORDER BY posRating / numRatings DESC LIMIT 10');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWorstHeroes()
    {
        $stmt = $this->db->prepare('SELECT * FROM hero ORDER BY posRating / numRatings ASC LIMIT 10');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHeroById($heroId)
    {
        $stmt = $this->db->prepare('SELECT * FROM hero WHERE heroId = :heroId');
        $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getHeroByUserId($userId)
    {
        $stmt = $this->db->prepare('SELECT * FROM hero WHERE userId = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createHero($heroData)
    {
        $stmt = $this->db->prepare("INSERT INTO hero (hero_name, real_name, posRating, numRatings, strength, intellect, energy, speed, powers, image, userId) 
                                      VALUES (:hero_name, :real_name, 1, 1, :strength, :intellect, :energy, :speed, :powers, :image, :userId)");
        $stmt->bindParam(':hero_name', $heroData['hero_name'], PDO::PARAM_STR);
        $stmt->bindParam(':real_name', $heroData['real_name'], PDO::PARAM_STR);
        $stmt->bindParam(':strength', $heroData['strength'], PDO::PARAM_INT);
        $stmt->bindParam(':intellect', $heroData['intellect'], PDO::PARAM_INT);
        $stmt->bindParam(':energy', $heroData['energy'], PDO::PARAM_INT);
        $stmt->bindParam(':speed', $heroData['speed'], PDO::PARAM_INT);
        $stmt->bindParam(':powers', $heroData['powers'], PDO::PARAM_STR);
        $stmt->bindParam(':image', $heroData['image'], PDO::PARAM_STR);
        $stmt->bindParam(':userId', $heroData['userId'], PDO::PARAM_INT);
        $stmt->execute();
    }

    public function rateHeroUp($heroId)
    {
        $stmt = $this->db->prepare("UPDATE hero SET posRating = posRating + 1, numRatings = numRatings + 1 WHERE heroId = :heroId");
        $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function rateHeroDown($heroId)
    {
        if($heroId != 5) {
            $stmt = $this->db->prepare("UPDATE hero SET numRatings = numRatings + 1 WHERE heroId = :heroId");
            $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
}
?>
