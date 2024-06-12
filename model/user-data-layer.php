<?php

/**
 * Class UserDataLayer
 * Handles database operations related to user data.
 */
class UserDataLayer
{
    /**
     * @var PDO Database connection instance.
     */
    private $db;

    /**
     * UserDataLayer constructor.
     *
     * @param PDO $db Database connection instance.
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Fetches user data by email.
     *
     * @param string $email User's email address.
     * @return array|false Associative array of user data, or false if not found.
     */
    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Creates a new user in the database.
     *
     * @param string $name User's name.
     * @param string $email User's email address.
     * @param string $hashedPassword Hashed password for the user.
     * @return int|null ID of the newly created user, or null on failure.
     */
    public function createUser($name, $email, $hashedPassword)
    {
        $stmt = $this->db->prepare("INSERT INTO user (name, email, password, isAdmin) VALUES (:name, :email, :password, 0)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    /**
     * Fetches user data by user ID.
     *
     * @param int $userId User ID.
     * @return array|false Associative array of user data, or false if not found.
     */
    public function getUserById($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE userId = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
