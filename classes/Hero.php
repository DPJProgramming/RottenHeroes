<?php
/**
 * Hero class representing a superhero with various attributes.
 *
 * This class extends the User class and adds additional properties specific to a superhero,
 * such as strength, intellect, energy, speed, powers, real name, and visibility of real name.
 *
 * @category   Classes
 * @package    Classes
 * @subpackage Hero
 * @author     Your Name <your.email@example.com>
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       https://example.com/classes/Hero.php
 */
namespace classes;

class Hero extends User
{
    /**
     * @var int Positive ratings received by the hero.
     */
    private $_posRatings;

    /**
     * @var int Number of ratings received by the hero.
     */
    private $_numRatings;

    /**
     * @var int Strength level of the hero.
     */
    private $_strength;

    /**
     * @var int Intellect level of the hero.
     */
    private $_intellect;

    /**
     * @var int Energy level of the hero.
     */
    private $_energy;

    /**
     * @var int Speed level of the hero.
     */
    private $_speed;

    /**
     * @var array Powers possessed by the hero.
     */
    private $_powers;

    /**
     * @var string Real name of the hero.
     */
    private $_realName;

    /**
     * @var bool Whether the real name of the hero should be hidden.
     */
    private $_hideRealName;

    /**
     * Constructor for Hero class.
     *
     * @param int    $_posRatings   Positive ratings received by the hero.
     * @param int    $_numRatings   Number of ratings received by the hero.
     * @param int    $_strength     Strength level of the hero.
     * @param int    $_intellect    Intellect level of the hero.
     * @param int    $_energy       Energy level of the hero.
     * @param int    $_speed        Speed level of the hero.
     * @param array  $_powers       Powers possessed by the hero.
     * @param string $_realName     Real name of the hero.
     * @param bool   $_hideRealName Whether the real name of the hero should be hidden.
     */
    public function __construct(
        int $_posRatings = 0,
        int $_numRatings = 1,
        int $_strength = 10,
        int $_intellect = 10,
        int $_energy = 10,
        int $_speed = 10,
        array $_powers = [],
        string $_realName = '',
        bool $_hideRealName = true
    ) {
        parent::__construct();

        $this->_posRatings = $_posRatings;
        $this->_numRatings = $_numRatings;
        $this->_strength = $_strength;
        $this->_intellect = $_intellect;
        $this->_energy = $_energy;
        $this->_speed = $_speed;
        $this->_powers = $_powers;
        $this->_realName = $_realName;
        $this->_hideRealName = $_hideRealName;
    }

    /**
     * Get the number of ratings received by the hero.
     *
     * @return int
     */
    public function getNumRatings(): int
    {
        return $this->_numRatings;
    }

    /**
     * Set the number of ratings received by the hero.
     *
     * @param int $numRatings The number of ratings received by the hero.
     * @return void
     */
    public function setNumRatings(int $numRatings): void
    {
        $this->_numRatings = $numRatings;
    }

    /**
     * Get the positive ratings received by the hero.
     *
     * @return int
     */
    public function getPosRatings(): int
    {
        return $this->_posRatings;
    }

    /**
     * Set the positive ratings received by the hero.
     *
     * @param int $rating The positive ratings received by the hero.
     * @return void
     */
    public function setPosRatings(int $rating): void
    {
        $this->_posRatings = $rating;
    }

    /**
     * Get the strength level of the hero.
     *
     * @return int
     */
    public function getStrength(): int
    {
        return $this->_strength;
    }

    /**
     * Set the strength level of the hero.
     *
     * @param int $strength The strength level of the hero.
     * @return void
     */
    public function setStrength(int $strength): void
    {
        $this->_strength = $strength;
    }

    /**
     * Get the intellect level of the hero.
     *
     * @return int
     */
    public function getIntellect(): int
    {
        return $this->_intellect;
    }

    /**
     * Set the intellect level of the hero.
     *
     * @param int $intellect The intellect level of the hero.
     * @return void
     */
    public function setIntellect(int $intellect): void
    {
        $this->_intellect = $intellect;
    }

    /**
     * Get the energy level of the hero.
     *
     * @return int
     */
    public function getEnergy(): int
    {
        return $this->_energy;
    }

    /**
     * Set the energy level of the hero.
     *
     * @param int $energy The energy level of the hero.
     * @return void
     */
    public function setEnergy(int $energy): void
    {
        $this->_energy = $energy;
    }

    /**
     * Get the speed level of the hero.
     *
     * @return int
     */
    public function getSpeed(): int
    {
        return $this->_speed;
    }

    /**
     * Set the speed level of the hero.
     *
     * @param int $speed The speed level of the hero.
     * @return void
     */
    public function setSpeed(int $speed): void
    {
        $this->_speed = $speed;
    }

    /**
     * Get the powers possessed by the hero.
     *
     * @return array
     */
    public function getPowers(): array
    {
        return $this->_powers;
    }

    /**
     * Set the powers possessed by the hero.
     *
     * @param array $powers The powers possessed by the hero.
     * @return void
     */
    public function setPowers(array $powers): void
    {
        $this->_powers = $powers;
    }

    /**
     * Get the real name of the hero.
     *
     * @return string
     */
    public function getRealName(): string
    {
        return $this->_realName;
    }

    /**
     * Set the real name of the hero.
     *
     * @param string $realName The real name of the hero.
     * @return void
     */
    public function setRealName(string $realName): void
    {
        $this->_realName = $realName;
    }

    /**
     * Check if the real name of the hero should be hidden.
     *
     * @return bool
     */
    public function getHideRealName(): bool
    {
        return $this->_hideRealName;
    }

    /**
     * Set whether the real name of the hero should be hidden.
     *
     * @param bool $hideRealName Whether the real name of the hero should be hidden.
     * @return void
     */
    public function setHideRealName(bool $hideRealName): void
    {
        $this->_hideRealName = $hideRealName;
    }

    /**
     * Set the user ID associated with the hero.
     *
     * @param mixed $userId The user ID associated with the hero.
     * @return void
     */
    public function setUserId($userId): void
    {
        parent::setUserId($userId);
    }

    /**
     * Get the user ID associated with the hero.
     *
     * @return mixed
     */
    public function getUserId()
    {
        return parent::getUserId();
    }

}
