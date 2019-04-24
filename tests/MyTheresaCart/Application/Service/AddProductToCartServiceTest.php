<?php


namespace App\Tests\MyTheresaCart\Application\Service;


use App\MyTheresaCart\Application\Service\AddProductToCartRequest;
use App\MyTheresaCart\Application\Service\AddProductToCartService;
use App\MyTheresaCart\Domain\Model\Shop\ProductId;
use App\MyTheresaCart\Infrastructure\Persistence\InMemoryProductRepository;
use App\MyTheresaCart\Infrastructure\Persistence\InMemoryUserRepository;
use App\Tests\MyTheresaCart\Infrastructure\Domain\DummyAuthenticator;
use PHPUnit\Framework\TestCase;

class AddProductToCartServiceTest extends TestCase
{

    /**
     * @var AddProductToCartService
     */
    private $addProductToCartService;
    /**
     * @var DummyAuthenticator
     */
    private $dummyAuthenticator;
    /**
     * @var InMemoryUserRepository
     */
    private $userRepository;
    /**
     * @var InMemoryProductRepository
     */
    private $productRepository;


    protected function setUp()
    {
        $this->dummyAuthenticator = new DummyAuthenticator();
        $this->userRepository = new InMemoryUserRepository();
        $this->productRepository = new InMemoryProductRepository();
        $this->addProductToCartService = new AddProductToCartService(
            $this->dummyAuthenticator,
            $this->productRepository,
            $this->userRepository
        );
    }


    public function testAddIsSuccessful()
    {
        $result = $this->addProductToCartService->execute(new AddProductToCartRequest(new ProductId(1)));
        $this->assertTrue($result);
        $currentUser = $this->dummyAuthenticator->currentUserOrThrow();
        $products = $currentUser->cart()->products();
        $this->assertGreaterThan(0, count($products));

        $storerUser = $this->userRepository->byId($currentUser->id());

        $this->assertNotNull($storerUser);
    }

    /**
     * @expectedException \App\MyTheresaCart\Domain\Model\Shop\ProductNotFoundException
     */
    public function testAddThrowsOnNonExistingProduct()
    {
        $this->addProductToCartService->execute(new AddProductToCartRequest(new ProductId(123123123)));
    }
}