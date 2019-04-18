<?php


namespace App\MyTheresaCart\Application\Service;


use App\MyTheresaCart\Domain\Model\Authenticator;

final class SigninUserService
{
    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * SigninUserService constructor.
     * @param Authenticator $authenticator
     */
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function execute(string $email, string $password): bool
    {
        return $this->authenticator->authenticate($email, $password);
    }
}