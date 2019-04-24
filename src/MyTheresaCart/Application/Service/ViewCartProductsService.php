<?php


namespace App\MyTheresaCart\Application\Service;


use App\MyTheresaCart\Domain\Model\Authenticator;
use App\MyTheresaCart\Domain\Model\Shop\Product;

final class ViewCartProductsService
{
    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * ViewProductsOfCartService constructor.
     * @param Authenticator $authenticator
     */
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * @return Product[]
     */
    public function execute(): array
    {
        $currentUser = $this->authenticator->currentUserOrThrow();

        return $currentUser->cart()->products();
    }
}