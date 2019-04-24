<?php


namespace App\MyTheresaCart\Application\Service;


use App\MyTheresaCart\Domain\Model\Shop\ProductId;

final class AddProductToCartRequest
{
    /**
     * @var ProductId
     */
    private $productId;

    /**
     * AddProductToCartRequest constructor.
     * @param ProductId $productId
     */
    public function __construct(ProductId $productId)
    {
        $this->productId = $productId;
    }

    public function productId(): ProductId
    {
        return $this->productId;
    }
}