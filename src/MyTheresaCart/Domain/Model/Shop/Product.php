<?php


namespace App\MyTheresaCart\Domain\Model\Shop;


final class Product
{

    /**
     * @var ProductId
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $price;

    /**
     * Product constructor.
     * @param ProductId $id
     * @param string $name
     * @param int $price
     */
    public function __construct(ProductId $id, string $name, int $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): int
    {
        return $this->price;
    }
}