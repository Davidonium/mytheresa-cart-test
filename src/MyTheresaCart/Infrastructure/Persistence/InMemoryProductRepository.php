<?php


namespace App\MyTheresaCart\Infrastructure\Persistence;


use App\MyTheresaCart\Domain\Model\Shop\Product;
use App\MyTheresaCart\Domain\Model\Shop\ProductId;
use App\MyTheresaCart\Domain\Model\Shop\ProductRepository;

class InMemoryProductRepository implements ProductRepository
{
    private $products = [];

    /**
     * InMemoryProductRepository constructor.
     */
    public function __construct()
    {
        $this->products[1] = new Product(new ProductId(1), "Purse that is too expensive", 100000);
        $this->products[2] = new Product(new ProductId(2), "Shoes that my girlfriend wants", 300000);
        $this->products[3] = new Product(new ProductId(3), "Totally not chinese sunglasses", 14000);
    }


    public function byId(ProductId $productId): ?Product
    {
        return $this->products[$productId->id()];
    }


}