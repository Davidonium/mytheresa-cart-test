<?php


namespace App\MyTheresaCart\Application\Service;


use App\MyTheresaCart\Domain\Model\Authenticator;
use App\MyTheresaCart\Domain\Model\Shop\OrderRepository;
use App\MyTheresaCart\Domain\Model\Shop\ProductNotFoundException;
use App\MyTheresaCart\Domain\Model\Shop\ProductRepository;
use App\MyTheresaCart\Domain\Model\User\UserRepository;

final class AddProductToCartService
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * AddProductToCartService constructor.
     * @param Authenticator $authenticator
     * @param ProductRepository $productRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        Authenticator $authenticator,
        ProductRepository $productRepository,
        UserRepository $userRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->authenticator = $authenticator;
        $this->userRepository = $userRepository;
    }

    public function execute(AddProductToCartRequest $addProductToCartRequest): bool
    {

        $product = $this->productRepository->byId($addProductToCartRequest->productId());

        if (!$product) {
            throw new ProductNotFoundException();
        }

        $currentUser = $this->authenticator->currentUserOrThrow();
        $currentUser->cart()->addProduct($product);
        $this->userRepository->save($currentUser);

        return true;
    }
}