<?php


namespace App\MyTheresaCart\Application\Controller;


use App\MyTheresaCart\Application\Service\SigninUserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UserController
{
    public function signin(Request $request, SigninUserService $signinUserService): Response
    {
        $result = $signinUserService->execute($request->request->get('email'), $request->request->get('password'));
        return JsonResponse::create(['success' => $result]);
    }
}