<?php


namespace App\MyTheresaCart\Application\Service;


use App\MyTheresaCart\Domain\Model\Authenticator;

final class SignInUserService
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

    public function execute(string $email, string $password): SignInResult
    {
        $result = $this->authenticator->authenticate($email, $password);
        if (!$result) {
            return new SignInResult(false);
        }
        $token = $this->authenticator->currentUserOrThrow()->token();
        return new SignInResult(true, $token);
    }
}