<?php


namespace App\MyTheresaCart\Infrastructure\Domain;


use App\MyTheresaCart\Domain\Model\Authenticator;
use App\MyTheresaCart\Domain\Model\User\User;
use App\MyTheresaCart\Domain\Model\User\UserId;
use App\MyTheresaCart\Domain\Model\User\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class TokenBasedAuthenticator implements Authenticator
{
    const CURRENT_USER_ATTRIBUTE = 'current_user';


    /**
     * @var UserRepository
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
     * TokenBaseAuthenticator constructor.
     * @param RequestStack $requestStack
     * @param UserRepository $userRepository
     * @param TokenGenerator $tokenGenerator
     */
    public function __construct(
        RequestStack $requestStack,
        UserRepository $userRepository,
        TokenGenerator $tokenGenerator
    )
    {
        $this->requestStack = $requestStack;
        $this->userRepository = $userRepository;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function currentUserId(): ?UserId
    {
        if ($this->currentUser()) {
            return $this->currentUser()->id();
        }

        return null;
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

        if (!password_verify($password, $user->password())) {
            return false;
        }

        $this->persistAuthentication($user);

        return true;
    }

    public function currentUser(): ?User
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        if ($currentRequest->attributes->has(self::CURRENT_USER_ATTRIBUTE)) {
            return $currentRequest->attributes->get(self::CURRENT_USER_ATTRIBUTE);
        }

        $authentication = $currentRequest->headers->get('Authorization');

        $token = str_replace('Bearer: ', '', $authentication);

        $currentUser = $this->userRepository->byToken($token);
        if ($currentUser === null) {
            return null;
        }

        $currentRequest->attributes->set(self::CURRENT_USER_ATTRIBUTE, $currentUser);

        return $currentUser;
    }

    private function persistAuthentication(User $user)
    {
        $newToken = $this->tokenGenerator->generate();
        $user->changeToken($newToken);
        $this->userRepository->save($user);
        $this->requestStack->getCurrentRequest()->attributes->set(self::CURRENT_USER_ATTRIBUTE, $user);
    }

    private function isAlreadyAuthenticated(): bool
    {
        return $this->currentUser() !== null;
    }

}