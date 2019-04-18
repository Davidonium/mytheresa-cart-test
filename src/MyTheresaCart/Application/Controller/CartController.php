<?php


namespace App\MyTheresaCart\Application\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CartController
{
    public function add(): Response
    {
        return JsonResponse::create(['success' => true]);
    }

    public function list(): Response
    {
        return JsonResponse::create([]);
    }
}