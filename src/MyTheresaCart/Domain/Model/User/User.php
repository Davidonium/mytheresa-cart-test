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
     * User constructor.
     * @param UserId $id
     * @param $email
     * @param $password
     */
    public function __construct(UserId $id, string $email, string $password)
    {
        $this->id = $id;
        $this->setEmail($email);
        $this->changePassword($password);
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

    private function setEmail(string $email)
    {
        $email = trim($email);
        if (empty($email)) {
            throw new \InvalidArgumentException('Invalid email');
        }

        $this->email = $email;
    }

    public function changePassword(string $password)
    {
        if (empty($password)) {
            throw new \InvalidArgumentException('Invalid password');
        }

        $this->password = $password;
    }
}