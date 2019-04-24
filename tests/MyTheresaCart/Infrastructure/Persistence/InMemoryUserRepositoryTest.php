<?php


namespace App\Tests\MyTheresaCart\Infrastructure\Persistence;


use App\MyTheresaCart\Domain\Model\User\UserId;
use App\MyTheresaCart\Infrastructure\Persistence\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;

class InMemoryUserRepositoryTest extends TestCase
{
    /**
     * @var InMemoryUserRepository
     */
    private $userRepository;

    protected function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
    }


    public function testFindByEmailIsSuccessful()
    {
        $emailToTest = "david.hernando@mytheresa.com";
        $user = $this->userRepository->byEmail($emailToTest);

        $this->assertNotNull($user);
        $this->assertEquals($emailToTest, $user->email());
    }

    public function testFindByEmailIsCaseSensitive()
    {
        $emailToTest = "David.hernando@mytheresa.com";
        $user = $this->userRepository->byEmail($emailToTest);

        $this->assertNull($user);
    }

    public function testNotFoundEmailReturnsNull()
    {
        $emailToTest = "not.found.email@mytheresa.com";
        $user = $this->userRepository->byEmail($emailToTest);

        $this->assertNull($user);
    }

    public function testfindByUserIdIsSuccessful()
    {
        $user = $this->userRepository->byId(new UserId(1));

        $this->assertNotNull($user);
    }

    public function testfindByUserIdReturnsNullOnNotFoundUserId()
    {
        $user = $this->userRepository->byId(new UserId(102312));

        $this->assertNull($user);
    }
}