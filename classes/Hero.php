<?php

namespace classes;

class Hero extends User
{
    //name userid comment[] etc are in User class
    private $_rating;
    private $_strength;
    private$_intellect;
    private$_energy;
    private$_speed;
    private $_powers = array();

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
    public function getStrength()
    {
        return $this->_strength;
    }

    /**
     * @param mixed $strength
     */
    public function setStrength($strength): void
    {
        $this->_strength = $strength;
    }

    /**
     * @return mixed
     */
    public function getIntellect()
    {
        return $this->_intellect;
    }

    /**
     * @param mixed $intellect
     */
    public function setIntellect($intellect): void
    {
        $this->_intellect = $intellect;
    }

    /**
     * @return mixed
     */
    public function getEnergy()
    {
        return $this->_energy;
    }

    /**
     * @param mixed $energy
     */
    public function setEnergy($energy): void
    {
        $this->_energy = $energy;
    }

    /**
     * @return mixed
     */
    public function getSpeed()
    {
        return $this->_speed;
    }

    /**
     * @param mixed $speed
     */
    public function setSpeed($speed): void
    {
        $this->_speed = $speed;
    }

    public function getPowers(): array
    {
        return $this->_powers;
    }

    public function setPowers(array $powers): void
    {
        $this->_powers = $powers;
    }
}