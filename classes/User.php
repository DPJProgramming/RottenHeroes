<?php
/**
 * User class representing a basic user entity.
 *
 * This class encapsulates properties and methods related to a user,
 * including user ID, name, email, password, and admin status.
 *
 * @category   Classes
 * @package    Classes
 * @subpackage User
 * @author     Your Name <your.email@example.com>
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       https://example.com/classes/User.php
 */
namespace classes;

class User
{
    /**
     * @var mixed User ID.
     */
    private $userId;

    /**
     * @var string User's name.
     */
    private $name;

    /**
     * @var string User's email address.
     */
    private $email;

    /**
     * @var string User's password.
     */
    private $password;

    /**
     * @var bool Whether the user is an admin.
     */
    private $isAdmin;

    /**
     * Constructor for User class.
     *
     * @param string $name     User's name. Default is 'default_user'.
     * @param string $email    User's email address. Default is 'user@example.com'.
     * @param string $password User's password.
     * @param bool   $isAdmin  Whether the user is an admin. Default is false.
     */
    public function __construct($name = 'default_user', $email = 'user@example.com', $password = '', $isAdmin = false)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Get the user ID.
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the user ID.
     *
     * @param mixed $userId The user ID.
     * @return void
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get the user's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the user's name.
     *
     * @param string $name The user's name.
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the user's email address.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the user's email address.
     *
     * @param string $email The user's email address.
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get the user's password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the user's password.
     *
     * @param string $password The user's password.
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set whether the user is an admin.
     *
     * @param bool $isAdmin Whether the user is an admin.
     * @return void
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }
}
