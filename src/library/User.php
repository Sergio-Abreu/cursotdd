<?php
namespace cursoTDD\library;

class User
{
    /**
     * @var string
     */
    private $username;
    /**
     * @var int
     */
    private $registrationNumber;

    /**
     * User constructor.
     * @param string  $username
     * @param integer $registrationNumber
     */
    public function __construct($username, $registrationNumber)
    {
        $this->username = $username;
        $this->registrationNumber = $registrationNumber;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getRegistrationNumber()
    {
        return $this->registrationNumber;
    }
}
