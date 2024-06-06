<?php

namespace classes;

use DateTime;

class Comment
{
    private $_body;
    private $_heroPage;
    private $_userId;
    private $_userName;
    private $_date;
    private $_rating;

    public function __construct($text = "")
    {
        $this-> _body = $text;
        $this-> _date = (new DateTime())->format('Y-m-d H:i:s');
        $this->_rating = 0;
        $this->_isBlog = false;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->_userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName): void
    {
        $this->_userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getHeroPage()
    {
        return $this->_heroPage;
    }

    /**
     * @param mixed $heroPage
     */
    public function setHeroPage($heroPage): void
    {
        $this->_heroPage = $heroPage;
    }
    private $_isBlog;

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->_body = $body;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->_userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->_date = $date;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->_rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating): void
    {
        $this->_rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getHeroId()
    {
        return $this->_heroId;
    }

    /**
     * @param mixed $heroId
     */
    public function setHeroId($heroId): void
    {
        $this->_heroId = $heroId;
    }

    /**
     * @return mixed
     */
    public function getIsBlog()
    {
        return $this->_isBlog;
    }

    /**
     * @param mixed $isBlog
     */
    public function setIsBlog($isBlog): void
    {
        $this->_isBlog = $isBlog;
    }


}