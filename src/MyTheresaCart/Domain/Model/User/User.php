<?php


namespace App\MyTheresaCart\Domain\Model\User;


final class User
{
    /**
     * @var UserId
     */
    private $id;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string|null
     */
    private $token;

    /**
     * User constructor.
     * @param UserId $id
     * @param string $email
     * @param string $password
     * @param string|null $token
     */
    public function __construct(
        UserId $id,
        string $email,
        string $password,
        ?string $token = null
    )
    {
        $this->id = $id;
        $this->setEmail($email);
        $this->changePassword($password);
        $this->token = $token;
    }

    /**
     * @return UserId
     */
    public function id(): UserId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function changePassword(string $password)
    {
        if (empty($password)) {
            throw new \InvalidArgumentException('Invalid password');
        }

        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function changeToken(string $token)
    {
        if (empty($token)) {
            throw new \InvalidArgumentException('Invalid password');
        }

        $this->token = $token;
    }

    private function setEmail(string $email)
    {
        $email = trim($email);
        if (empty($email)) {
            throw new \InvalidArgumentException('Invalid email');
        }

        $this->email = $email;
    }
}