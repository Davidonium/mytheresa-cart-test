<?php

namespace App\MyTheresaCart\Domain\Model\User;


final class UserId
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @param int|null $id
     */
    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function equals(UserId $userId): bool
    {
        return $this->id() === $userId->id();
    }

    public function __toString(): string
    {
        return (string) $this->id();
    }
}
