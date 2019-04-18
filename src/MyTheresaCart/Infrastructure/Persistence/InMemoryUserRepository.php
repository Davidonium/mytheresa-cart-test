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
        $this->users[] = new User(new UserId(1), "david.hernando@mytheresa.com", "memorypassword");
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
        foreach ($this->users as $user) {
            if ($user->id()->equals($id)) {
                return $user;
            }
        }

        return null;
    }

}