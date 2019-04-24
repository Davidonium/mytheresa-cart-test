<?php


namespace App\Tests\MyTheresaCart\Infrastructure\Domain;


use App\MyTheresaCart\Domain\Model\Authenticator;
use App\MyTheresaCart\Domain\Model\User\User;
use App\MyTheresaCart\Domain\Model\User\UserId;

class DummyAuthenticator implements Authenticator
{
    private $user;

    /**
     * DummyAuthenticator constructor.
     */
    public function __construct()
    {
        $user = new User(new UserId(1), "dummy@dummy.com", "dummypassword", "dummyToken");
        $this->user = $user;
    }


    public function authenticate(string $email, string $password): bool
    {
        return true;
    }

    public function currentUser(): ?User
    {
        return $this->user;
    }

    public function currentUserOrThrow(): User
    {
        return $this->user;
    }

}