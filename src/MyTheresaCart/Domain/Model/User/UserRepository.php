<?php


namespace App\MyTheresaCart\Domain\Model\User;


interface UserRepository
{
    public function byEmail(string $email): ?User;
    public function byId(UserId $id): ?User;

}