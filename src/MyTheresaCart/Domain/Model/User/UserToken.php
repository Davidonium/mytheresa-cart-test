<?php


namespace App\MyTheresaCart\Domain\Model\User;


final class UserToken
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var string
     */
    private $email;

    public static function fromUser(User $user): self
    {
        return new self($user->id(), $user->email());
    }

    private function __construct(UserId $userId, string $email)
    {
        $this->userId = $userId;
        $this->email = $email;
    }

    public function id(): UserId
    {
        return $this->userId;
    }

    public function email(): string
    {
        return $this->email;
    }
}