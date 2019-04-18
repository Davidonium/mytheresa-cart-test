<?php


namespace App\Tests\MyTheresaCart\Application\Service;


use App\MyTheresaCart\Application\Service\SigninUserService;
use App\MyTheresaCart\Infrastructure\Domain\SessionAuthenticator;
use App\MyTheresaCart\Infrastructure\Persistence\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class SigninUserServiceTest extends TestCase
{

    /**
     * @var SigninUserService
     */
    private $signinUserService;


    private $existingEmail = "david.hernando@mytheresa.com";
    private $existingPassword = "memorypassword";

    private $nonExistingEmail = "nonexistingemail@mytheresa.com";
    private $wrongPassword = "wrongpassword";

    protected function setUp()
    {
        $userRepository = new InMemoryUserRepository();
        $session = new Session(new MockArraySessionStorage());
        $sessionAuthenticator = new SessionAuthenticator($userRepository, $session);
        $this->signinUserService = new SigninUserService($sessionAuthenticator);
    }

    public function testSigninIsSuccessful()
    {
        $result = $this->signinUserService->execute($this->existingEmail, $this->existingPassword);

        $this->assertTrue($result);
    }


    public function testSigninIsFalseOnWrongEmail()
    {
        $result = $this->signinUserService->execute($this->nonExistingEmail, $this->existingPassword);

        $this->assertFalse($result);
    }

    public function testSigninIsFalseOnWrongPassword()
    {
        $result = $this->signinUserService->execute($this->nonExistingEmail, $this->wrongPassword);

        $this->assertFalse($result);
    }


}