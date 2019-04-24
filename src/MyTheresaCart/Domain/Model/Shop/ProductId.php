<?php


namespace App\MyTheresaCart\Domain\Model\Shop;


final class ProductId
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @param int $id
     */
    public function __construct(?int $id = null)
    {
        $this->id = $id ?? random_int(1, 100000);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->id();
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function equals(self $productId): bool
    {
        return $this->id() === $productId->id();
    }
}