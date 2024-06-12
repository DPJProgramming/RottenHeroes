<?php

/**
 * Class HeroDataLayer
 * Data layer for managing hero data.
 */
class HeroDataLayer
{
    /** @var PDO Database connection instance. */
    private $db;

    /**
     * HeroDataLayer constructor.
     *
     * @param PDO $db Database connection instance.
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Retrieves top rated heroes.
     *
     * @return array Array of top rated heroes fetched from the database.
     */
    public function getTopHeroes()
    {
        $stmt = $this->db->prepare('SELECT * FROM hero ORDER BY posRating / numRatings DESC LIMIT 10');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves worst rated heroes.
     *
     * @return array Array of worst rated heroes fetched from the database.
     */
    public function getWorstHeroes()
    {
        $stmt = $this->db->prepare('SELECT * FROM hero ORDER BY posRating / numRatings ASC LIMIT 10');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves hero by ID.
     *
     * @param int $heroId The ID of the hero.
     * @return array|null Hero data fetched from the database.
     */
    public function getHeroById($heroId)
    {
        $stmt = $this->db->prepare('SELECT * FROM hero WHERE heroId = :heroId');
        $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves hero by user ID.
     *
     * @param int $userId The ID of the user.
     * @return array|null Hero data fetched from the database.
     */
    public function getHeroByUserId($userId)
    {
        $stmt = $this->db->prepare('SELECT * FROM hero WHERE userId = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Creates a new hero.
     *
     * @param array $heroData Array containing hero data.
     */
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

    /**
     * Increases the positive rating of a hero.
     *
     * @param int $heroId The ID of the hero.
     */
    public function rateHeroUp($heroId)
    {
        $stmt = $this->db->prepare("UPDATE hero SET posRating = posRating + 1, numRatings = numRatings + 1 WHERE heroId = :heroId");
        $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Increases the number of ratings for a hero.
     *
     * @param int $heroId The ID of the hero.
     */
    public function rateHeroDown($heroId)
    {
        $stmt = $this->db->prepare("UPDATE hero SET numRatings = numRatings + 1 WHERE heroId = :heroId");
        $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
        $stmt->execute();
    }
}

?>
