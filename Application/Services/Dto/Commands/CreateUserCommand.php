<?php
declare(strict_types=1);

final class CreateUserCommand
{
    private string $id;
    private string $name;
    private string $email;
    private string $password;
    private string $role;

    public function __construct(
        string $id,
        string $name,
        string $email,
        string $password,
        string $role
    ) {
        $this->id       = trim($id);
        $this->name     = trim($name);
        $this->email    = trim($email);
        $this->password = trim($password);
        $this->role     = trim($role);
    }

    public function id(): string       { return $this->id; }
    public function name(): string     { return $this->name; }
    public function email(): string    { return $this->email; }
    public function password(): string { return $this->password; }
    public function role(): string     { return $this->role; }
}
