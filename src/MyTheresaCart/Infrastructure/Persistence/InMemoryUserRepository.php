<?php


namespace App\MyTheresaCart\Infrastructure\Persistence;


use App\MyTheresaCart\Domain\Model\User\User;
use App\MyTheresaCart\Domain\Model\User\UserId;
use App\MyTheresaCart\Domain\Model\User\UserRepository;


final class InMemoryUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private $users = [];

    /**
     * InMemoryUserRepository constructor.
     */
    public function __construct()
    {
        $id = 1;
        $this->users[$id] = new User(new UserId($id), "david.hernando@mytheresa.com", "memorypassword", "randomgeneratedtoken");
    }

    public function byEmail(string $email): ?User
    {
        foreach ($this->users as $user) {
            if ($user->email() === $email) {
                return $user;
            }
        }

        return null;
    }

    public function byId(UserId $id): ?User
    {
        if (isset($this->users[$id->id()])) {
            return $this->users[$id->id()];
        }

        return null;
    }

    public function byToken(string $token): ?User
    {
        foreach ($this->users as $user) {
            if ($user->token() === $token) {
                return $user;
            }
        }

        return null;
    }

    public function save(User $user)
    {
        $this->users[$user->id()->id()] = $user;
    }

}