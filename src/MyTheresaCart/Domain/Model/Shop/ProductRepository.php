<?php


namespace App\MyTheresaCart\Domain\Model\Shop;


interface ProductRepository
{
    public function byId(ProductId $productId): ?Product;
}