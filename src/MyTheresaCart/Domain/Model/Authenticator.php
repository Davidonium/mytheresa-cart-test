<?php


namespace App\MyTheresaCart\Domain\Model;


use App\MyTheresaCart\Domain\Model\User\User;
use App\MyTheresaCart\Domain\Model\User\UserId;
use App\MyTheresaCart\Domain\Model\User\UserRepository;

abstract class Authenticator
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Authenticator constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(string $email, string $password): bool
    {
        if ($this->isAlreadyAuthenticated()) {
            return true;
        }

        $user = $this->userRepository->byEmail($email);
        if (!$user) {
            return false;
        }

        if ($user->password() !== $password) {
            return false;
        }

        $this->persistAuthentication($user);

        return true;
    }

    public function currentUser(): ?User
    {
        $currentUserId = $this->currentUserId();
        if (!$currentUserId) {
            return null;
        }

        return $this->userRepository->byId($currentUserId);
    }

    abstract public function currentUserId(): ?UserId;

    abstract public function logout();
    abstract protected function persistAuthentication(User $user);
    abstract protected function isAlreadyAuthenticated(): bool;
}