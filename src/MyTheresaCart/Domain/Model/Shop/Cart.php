<?php


namespace App\MyTheresaCart\Domain\Model\Shop;


use App\MyTheresaCart\Domain\Model\User\UserId;

final class Cart
{
    /**
     * @var Product[]
     */
    private $products;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * Cart constructor.
     * @param UserId $userId
     */
    public function __construct(UserId $userId)
    {
        $this->products = [];
        $this->userId = $userId;
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function products()
    {
        return $this->products;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }
}