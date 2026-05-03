<?php
declare(strict_types=1);

final class LoginCommand
{
    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email    = trim(strtolower($email));
        $this->password = $password;
    }

    public function email(): string    { return $this->email; }
    public function password(): string { return $this->password; }
}
