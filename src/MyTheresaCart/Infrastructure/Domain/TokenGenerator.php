<?php


namespace App\MyTheresaCart\Infrastructure\Domain;


class TokenGenerator
{
    public function generate(): string
    {
        return bin2hex(random_bytes(32));
    }
}