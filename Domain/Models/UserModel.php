<?php

declare(strict_types=1);
require_once __DIR__ . '/../ValueObjects/UserId.php';
require_once __DIR__ . '/../ValueObjects/UserName.php';
require_once __DIR__ . '/../ValueObjects/UserEmail.php';
require_once __DIR__ . '/../ValueObjects/UserPassword.php';
require_once __DIR__ . '/../Enums/UserRolEnum.php';
require_once __DIR__ . '/../Enums/UserStatusEnum.php';
final class UserModel
{
    private UserId $id;
    private UserName $name;
    private UserEmail $email;
    private UserPassword $password;
    private string $rol;
    private string $status;
    private ?string $verificationToken;

    public function __construct
    (
        UserId $id,
        UserName $name,
        UserEmail $email,
        UserPassword $password,
        string $rol,
        string $status,
        ?string $verificationToken = null
    )
    {
        UserRolEnum::ensureIsValid($rol);
        UserStatusEnum::ensureIsValid($status);

        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
        $this->status = $status;
        $this->verificationToken = $verificationToken;
    }

    public static function create
    (
        UserId $id,
        UserName $name,
        UserEmail $email,
        UserPassword $password,
        string $rol,
        ?string $verificationToken = null
    ):self{

        return new self(
            $id,
            $name,
            $email,
            $password,
            $rol,
            UserStatusEnum::PENDING,
            $verificationToken
        );

    }

    public function verifyEmail(string $tokenToVerify): self{
        if($this->verificationToken !== $tokenToVerify){
            throw new DomainException('Token invalido');
        }

        return new self(
            $this->id,
            $this->name,
            $this->email,
            $this->password,
            $this->rol,
            UserStatusEnum::ACTIVE,
            null
        );
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public function rol(): string
    {
        return $this->rol;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function verificationToken(): ?string
    {
        return $this->verificationToken;
    }

    public function activate(): self
    {
        return new self(
           $this->id(),
           $this->name(),
           $this->email(),
           $this->password(),
           $this->rol(),
           UserStatusEnum::ACTIVE
        );
    }

    public function deactivate(): self
    {
        return new self(
            $this->id(),
            $this->name(),
            $this->email(),
            $this->password(),
            $this->rol(),
            UserStatusEnum::INACTIVE
        );
    }

    public function block(): self
    {
        return new self(
            $this->id(),
            $this->name(),
            $this->email(),
            $this->password(),
            $this->rol(),
            UserStatusEnum::BLOCKED
        );
    }

    public function changeName(UserName $newName): self
    {
        return new self(
            $this->id(),
            $newName,
            $this->email(),
            $this->password(),
            $this->rol(),
            $this->status
        );
    }

    public function changeEmail(UserEmail $newEmail): self
    {
        return new self(
            $this->id(),
            $newEmail,
            $this->email(),
            $this->password(),
            $this->rol(),
            $this->status
        );
    }

    public function changePassword(UserPassword $newPassword): self
    {
        return new self(
            $this->id(),
            $this->name(),
            $this->email(),
            $newPassword,
            $this->rol(),
            $this->status
        );
    }

    public function changeRol(string $rol): self
    {
        return new self(
            $this->id(),
            $this->name(),
            $this->email(),
            $this->password(),
            $rol,
            $this->status
        );
    }

    public function toArray(): array
    {
        return  array(
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'email' => $this->email->value(),
            'password' => $this->password->value(),
            'role' => $this->rol,
            'status' => $this->status
        );
    }

}