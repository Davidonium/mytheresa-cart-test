<?php


namespace App\MyTheresaCart\Infrastructure\Persistence;


use App\MyTheresaCart\Domain\Model\Shop\Cart;
use App\MyTheresaCart\Domain\Model\Shop\Product;
use App\MyTheresaCart\Domain\Model\Shop\ProductId;
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
        $userId = new UserId($id);
        $order = new Cart($userId);
        $order->addProduct(new Product(new ProductId(2), "Shoes that my girlfriend wants", 300000));
        $this->users[$id] = new User(
            $userId,
            "david.hernando@mytheresa.com",
            "memorypassword",
            "randomgeneratedtoken",
            $order
        );
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