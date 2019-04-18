<?php


namespace App\MyTheresaCart\Infrastructure\Domain;


use App\MyTheresaCart\Domain\Model\Authenticator;
use App\MyTheresaCart\Domain\Model\User\User;
use App\MyTheresaCart\Domain\Model\User\UserRepository;
use App\MyTheresaCart\Domain\Model\User\UserToken;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\MyTheresaCart\Domain\Model\User\UserId;

final class SessionAuthenticator extends Authenticator
{
    const USER_SESSION_KEY = 'user';
    /**
     * @var Session
     */
    private $session;

    public function __construct(UserRepository $userRepository, SessionInterface $session)
    {
        parent::__construct($userRepository);
        $this->session = $session;
    }

    protected function persistAuthentication(User $user)
    {
        $this->session->set(self::USER_SESSION_KEY, UserToken::fromUser($user));
    }

    public function currentUserId(): ?UserId
    {
        if (!$this->session->get(self::USER_SESSION_KEY)) {
            return null;
        }
        return $this->session->get(self::USER_SESSION_KEY)->id();
    }

    protected function isAlreadyAuthenticated(): bool
    {
        return $this->session->has(self::USER_SESSION_KEY);
    }

    public function logout()
    {
        $this->session->clear();
    }
}