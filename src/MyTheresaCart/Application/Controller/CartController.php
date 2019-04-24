<?php


namespace App\MyTheresaCart\Application\Controller;


use App\MyTheresaCart\Application\Service\AddProductToCartRequest;
use App\MyTheresaCart\Application\Service\AddProductToCartService;
use App\MyTheresaCart\Application\Service\ViewCartProductsService;
use App\MyTheresaCart\Domain\Model\Shop\ProductId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final class CartController
{
    public function add(AddProductToCartService $addProductToCartService, Request $request): Response
    {
        $productId = new ProductId($request->request->getInt('productId'));
        $addProductRequest = new AddProductToCartRequest($productId);
        $addProductToCartService->execute($addProductRequest);

        return Response::create('', Response::HTTP_CREATED);
    }

    public function list(SerializerInterface $serializer, ViewCartProductsService $viewCartProductsService): Response
    {
        $products = $viewCartProductsService->execute();
        return JsonResponse::fromJsonString($serializer->serialize($products, 'json'));
    }
}