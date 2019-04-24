<?php


namespace App\Tests\MyTheresaCart\Domain\Model\User;


use App\MyTheresaCart\Domain\Model\User\User;
use App\MyTheresaCart\Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testPasswordIsChanged()
    {
        $user = new User(new UserId(1), "validemail@valid.net", "test-password");

        $user->changePassword("test-password2");

        $this->assertTrue(password_verify("test-password2", $user->password()));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEmptyEmailThrows()
    {
        new User(new UserId(1), "", "");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEmptyPasswordThrows()
    {
        new User(new UserId(1), "validemail@valid.net", "");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testChangeEmptyPasswordThrows()
    {
        $user = new User(new UserId(1), "validemail@valid.net", "valid-password");

        $user->changePassword("");
    }
}