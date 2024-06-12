<?php
/**
 * Comment class for handling comments on hero pages.
 *
 * This class represents a comment entity with properties like body, user information,
 * date of creation, rating, and blog status.
 *
 * @category   Classes
 * @package    Classes
 * @subpackage Comment
 * @author     Your Name <your.email@example.com>
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       https://example.com/classes/Comment.php
 */
namespace classes;

use DateTime;

class Comment
{
    /**
     * @var string The body of the comment.
     */
    private $_body;

    /**
     * @var mixed The hero page associated with the comment.
     */
    private $_heroPage;

    /**
     * @var mixed The user ID associated with the comment.
     */
    private $_userId;

    /**
     * @var string The username of the commenter.
     */
    private $_userName;

    /**
     * @var string The date and time when the comment was created.
     */
    private $_date;

    /**
     * @var int The rating given to the comment.
     */
    private $_rating;

    /**
     * @var bool Whether the comment is associated with a blog post.
     */
    private $_isBlog;

    /**
     * Constructor for Comment class.
     *
     * @param string $text The body text of the comment.
     */
    public function __construct($text = "")
    {
        $this->_body = $text;
        $this->_date = (new DateTime())->format('Y-m-d H:i:s');
        $this->_rating = 0;
        $this->_isBlog = false;
    }

    /**
     * Get the username of the commenter.
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->_userName;
    }

    /**
     * Set the username of the commenter.
     *
     * @param string $userName The username of the commenter.
     * @return void
     */
    public function setUserName($userName): void
    {
        $this->_userName = $userName;
    }

    /**
     * Get the hero page associated with the comment.
     *
     * @return mixed
     */
    public function getHeroPage()
    {
        return $this->_heroPage;
    }

    /**
     * Set the hero page associated with the comment.
     *
     * @param mixed $heroPage The hero page associated with the comment.
     * @return void
     */
    public function setHeroPage($heroPage): void
    {
        $this->_heroPage = $heroPage;
    }

    /**
     * Get the body text of the comment.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * Set the body text of the comment.
     *
     * @param string $body The body text of the comment.
     * @return void
     */
    public function setBody($body): void
    {
        $this->_body = $body;
    }

    /**
     * Get the user ID associated with the comment.
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     * Set the user ID associated with the comment.
     *
     * @param mixed $userId The user ID associated with the comment.
     * @return void
     */
    public function setUserId($userId): void
    {
        $this->_userId = $userId;
    }

    /**
     * Get the date and time when the comment was created.
     *
     * @return string
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * Set the date and time when the comment was created.
     *
     * @param string $date The date and time when the comment was created.
     * @return void
     */
    public function setDate($date): void
    {
        $this->_date = $date;
    }

    /**
     * Get the rating given to the comment.
     *
     * @return int
     */
    public function getRating()
    {
        return $this->_rating;
    }

    /**
     * Set the rating given to the comment.
     *
     * @param int $rating The rating given to the comment.
     * @return void
     */
    public function setRating($rating): void
    {
        $this->_rating = $rating;
    }

    /**
     * Get the ID of the hero associated with the comment.
     *
     * @return mixed
     */
    public function getHeroId()
    {
        return $this->_heroId;
    }

    /**
     * Set the ID of the hero associated with the comment.
     *
     * @param mixed $heroId The ID of the hero associated with the comment.
     * @return void
     */
    public function setHeroId($heroId): void
    {
        $this->_heroId = $heroId;
    }

    /**
     * Check if the comment is associated with a blog post.
     *
     * @return bool
     */
    public function getIsBlog()
    {
        return $this->_isBlog;
    }

    /**
     * Set whether the comment is associated with a blog post.
     *
     * @param bool $isBlog Whether the comment is associated with a blog post.
     * @return void
     */
    public function setIsBlog($isBlog): void
    {
        $this->_isBlog = $isBlog;
    }
}
