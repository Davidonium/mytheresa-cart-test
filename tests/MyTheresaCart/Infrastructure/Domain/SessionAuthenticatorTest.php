<?php


namespace App\Tests\MyTheresaCart\Infrastructure\Domain;


use App\MyTheresaCart\Infrastructure\Domain\SessionAuthenticator;
use App\MyTheresaCart\Infrastructure\Persistence\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class SessionAuthenticatorTest extends TestCase
{
    /**
     * @var InMemoryUserRepository
     */
    private $userRepository;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var SessionAuthenticator
     */
    private $sessionAuthenticator;

    private $existingEmail = "david.hernando@mytheresa.com";
    private $existingPassword = "memorypassword";

    private $nonExistingEmail = "nonexistingemail@mytheresa.com";
    private $wrongPassword = "wrongpassword";

    protected function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->session = new Session(new MockArraySessionStorage());
        $this->sessionAuthenticator = new SessionAuthenticator($this->userRepository, $this->session);
    }

    public function testAuthenticateIsSuccessful()
    {
        $result = $this->sessionAuthenticator->authenticate($this->existingEmail, $this->existingPassword);

        $this->assertTrue($result);
    }

    public function testAuthenticateReturnsFalseOnNonExistingUser()
    {
        $result = $this->sessionAuthenticator->authenticate($this->nonExistingEmail, $this->wrongPassword);

        $this->assertFalse($result);
    }

    public function testAuthenticateReturnsFalseOnWrongPassword()
    {
        $result = $this->sessionAuthenticator->authenticate($this->existingEmail, $this->wrongPassword);

        $this->assertFalse($result);
    }


    public function testAuthenticatePopulatesCurrentUser()
    {
        $this->sessionAuthenticator->authenticate($this->existingEmail, $this->existingPassword);

        $userId = $this->sessionAuthenticator->currentUserId();

        $this->assertNotNull($userId);
        $this->assertEquals(1, $userId->id());

        $user = $this->sessionAuthenticator->currentUser();

        $this->assertNotNull($user);
        $this->assertEquals($this->existingEmail, $user->email());
        $this->assertEquals($this->existingPassword, $user->password());
    }

    public function testLogoutIsSuccessful()
    {
        $this->sessionAuthenticator->authenticate($this->existingEmail, $this->existingPassword);
        $this->sessionAuthenticator->logout();

        $user = $this->sessionAuthenticator->currentUser();
        $this->assertNull($user);

        $user = $this->sessionAuthenticator->currentUser();
        $this->assertNull($user);
    }

}