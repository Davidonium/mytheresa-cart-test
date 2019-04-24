<?php


namespace App\Tests\MyTheresaCart\Application\Service;


use App\MyTheresaCart\Application\Service\ViewCartProductsService;
use App\MyTheresaCart\Domain\Model\Shop\ProductId;
use App\MyTheresaCart\Infrastructure\Persistence\InMemoryProductRepository;
use App\Tests\MyTheresaCart\Infrastructure\Domain\DummyAuthenticator;
use PHPUnit\Framework\TestCase;

class ViewCartProductsServiceTest extends TestCase
{
    /**
     * @var ViewCartProductsService
     */
    private $viewCartProductsService;
    /**
     * @var DummyAuthenticator
     */
    private $dummyAuthenticator;
    /**
     * @var InMemoryProductRepository
     */
    private $productRepository;

    protected function setUp()
    {
        $this->productRepository = new InMemoryProductRepository();
        $this->dummyAuthenticator = new DummyAuthenticator();
        $this->viewCartProductsService = new ViewCartProductsService($this->dummyAuthenticator);
    }

    public function testEmptyProductsOnCartIsSuccessful()
    {
        $products = $this->viewCartProductsService->execute();
        $this->assertEmpty($products);
    }

    public function testAddedProductsArePresent()
    {
        $currentUser = $this->dummyAuthenticator->currentUserOrThrow();
        $currentUser->cart()->addProduct($this->productRepository->byId(new ProductId(1)));
        $products = $this->viewCartProductsService->execute();
        $this->assertEquals(1, count($products));

        $currentUser->cart()->addProduct($this->productRepository->byId(new ProductId(2)));

        $products = $this->viewCartProductsService->execute();
        $this->assertEquals(2, count($products));
    }
}