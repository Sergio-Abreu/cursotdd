<?php
namespace test\library;


use cursoTDD\library\User;

class UserTest extends \Codeception\Test\Unit
{
    const USER1 = 'Sérgio';
    const REGISTRATION_NUMBER1 = 30910878;
    /**
     * @var \UnitTester
     */
    protected $tester;
    /**
     * @var User
     */
    protected $user;

    protected function _before()
    {
        $this->user = new User(self::USER1, self::REGISTRATION_NUMBER1);
    }

    protected function _after()
    {
    }

    public function testGetUserName()
    {
        verify($this->user->getUsername())->equals(self::USER1);
    }

    public function testGetRegistrationNumber()
    {
        verify($this->user->getRegistrationNumber())->equals(self::REGISTRATION_NUMBER1);
    }
}
