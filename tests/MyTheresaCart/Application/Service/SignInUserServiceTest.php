<?php


namespace App\Tests\MyTheresaCart\Application\Service;


use App\MyTheresaCart\Application\Service\SignInUserService;
use App\MyTheresaCart\Domain\Model\User\UserRepository;
use App\MyTheresaCart\Infrastructure\Domain\SessionAuthenticator;
use App\MyTheresaCart\Infrastructure\Domain\TokenBasedAuthenticator;
use App\MyTheresaCart\Infrastructure\Domain\TokenGenerator;
use App\MyTheresaCart\Infrastructure\Persistence\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SignInUserServiceTest extends TestCase
{

    /**
     * @var SignInUserService
     */
    private $signinUserService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    private $existingEmail = "david.hernando@mytheresa.com";
    private $existingPassword = "memorypassword";

    private $nonExistingEmail = "nonexistingemail@mytheresa.com";
    private $wrongPassword = "wrongpassword";

    protected function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $requestStack = new RequestStack();
        $requestStack->push(new Request());
        $sessionAuthenticator = new TokenBasedAuthenticator($requestStack, $this->userRepository, new TokenGenerator());
        $this->signinUserService = new SignInUserService($sessionAuthenticator);
    }

    public function testSigninIsSuccessful()
    {
        $result = $this->signinUserService->execute($this->existingEmail, $this->existingPassword);

        $this->assertTrue($result->success());
    }


    public function testSigninIsFalseOnWrongEmail()
    {
        $result = $this->signinUserService->execute($this->nonExistingEmail, $this->existingPassword);

        $this->assertFalse($result->success());
    }

    public function testSigninIsFalseOnWrongPassword()
    {
        $result = $this->signinUserService->execute($this->nonExistingEmail, $this->wrongPassword);

        $this->assertFalse($result->success());
        $this->assertNull($result->token());
    }


}