<?php


namespace App\MyTheresaCart\Domain\Model\User;


use App\MyTheresaCart\Domain\Model\Shop\Cart;

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
     * @var Cart
     */
    private $order;

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
        ?string $token = null,
        ?Cart $cart = null
    )
    {
        $this->id = $id;
        $this->setEmail($email);
        $this->changePassword($password);
        $this->changeToken($token);
        $this->order = $cart ?? new Cart($this->id());
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

    public function changeToken(?string $token)
    {
        $this->token = $token;
    }

    public function cart(): Cart
    {
        return $this->order;
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