<?php


namespace App\Tests\MyTheresaCart\Infrastructure\Domain;


use App\MyTheresaCart\Infrastructure\Domain\TokenBasedAuthenticator;
use App\MyTheresaCart\Infrastructure\Domain\TokenGenerator;
use App\MyTheresaCart\Infrastructure\Persistence\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class TokenBasedAuthenticatorTest extends TestCase
{
    /**
     * @var InMemoryUserRepository
     */
    private $userRepository;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var TokenGenerator
     */
    private $tokenGenerator;

    /**
     * @var TokenBasedAuthenticator
     */
    private $authenticator;

    private $existingEmail = "david.hernando@mytheresa.com";
    private $existingPassword = "memorypassword";

    private $nonExistingEmail = "nonexistingemail@mytheresa.com";
    private $wrongPassword = "wrongpassword";

    protected function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->requestStack = new RequestStack();
        $this->requestStack->push(new Request());
        $this->tokenGenerator = new TokenGenerator();
        $this->authenticator = new TokenBasedAuthenticator($this->requestStack, $this->userRepository, $this->tokenGenerator);
    }

    public function testAuthenticateSuccess()
    {

        $result = $this->authenticator->authenticate($this->existingEmail, $this->existingPassword);

        $this->assertTrue($result);
    }

    public function testAuthenticateSuccessIfAlreadyLogged()
    {
        $this->requestStack->getCurrentRequest()->headers->add(['Authorization' => 'Bearer: randomgeneratedtoken']);;
        $result = $this->authenticator->authenticate($this->nonExistingEmail, $this->existingPassword);
        $this->assertTrue($result);
    }

    public function testAuthenticationFailureOnMissingEmail()
    {
        $result = $this->authenticator->authenticate($this->nonExistingEmail, $this->wrongPassword);
        $this->assertFalse($result);
    }

    public function testAuthenticationFailureOnWrongPassword()
    {
        $result = $this->authenticator->authenticate($this->existingEmail, $this->wrongPassword);
        $this->assertFalse($result);
    }

    public function testCurrentUserIsFilled()
    {
        $this->authenticator->authenticate($this->existingEmail, $this->existingPassword);
        $user = $this->authenticator->currentUser();
        $this->assertNotNull($user);
        $this->assertNotNull($this->authenticator->currentUserId());
        $this->assertNotNull($this->authenticator->currentUserId()->id());
        $this->assertEquals($this->existingEmail, $user->email());
    }
}