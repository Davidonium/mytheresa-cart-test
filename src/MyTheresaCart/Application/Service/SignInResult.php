<?php


namespace App\MyTheresaCart\Application\Service;


final class SignInResult
{
    /**
     * @var string|null
     */
    private $token;
    /**
     * @var bool
     */
    private $success;

    /**
     * SignInResult constructor.
     * @param bool $success
     * @param string $token
     */
    public function __construct(bool $success, ?string $token = null)
    {
        $this->token = $token;
        $this->success = $success;
    }

    public function success(): bool
    {
        return $this->success;
    }

    public function token(): ?string
    {
        return $this->token;
    }


}