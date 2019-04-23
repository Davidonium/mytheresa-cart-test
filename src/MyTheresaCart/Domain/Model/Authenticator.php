<?php


namespace App\MyTheresaCart\Domain\Model;


use App\MyTheresaCart\Domain\Model\User\User;
use App\MyTheresaCart\Domain\Model\User\UserId;

interface Authenticator
{
    public function authenticate(string $email, string $password): bool;

    public function currentUser(): ?User;

    public function currentUserId(): ?UserId;
}