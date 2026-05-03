<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/CreateUserUseCase.php';
require_once __DIR__ . '/../Ports/Out/SaveUserPort.php';
require_once __DIR__ . '/../Ports/Out/GetUserByEmailPort.php';
require_once __DIR__ . '/Dto/Commands/CreateUserCommand.php';
require_once __DIR__ . '/../../Domain/Models/UserModel.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserId.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserName.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserEmail.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserPassword.php';
require_once __DIR__ . '/../../Domain/Exceptions/UserAlreadyExistException.php';

final class CreateUserService implements CreateUserUseCase
{
    private SaveUserPort $saveUserPort;
    private GetUserByEmailPort $getUserByEmailPort;

    private SentVerificationEmailPort $sentVerificationEmailPort;

    public function __construct(
        SaveUserPort $saveUserPort,
        GetUserByEmailPort $getUserByEmailPort,
        SentVerificationEmailPort $sentVerificationEmailPort
    ) {
        $this->saveUserPort       = $saveUserPort;
        $this->getUserByEmailPort = $getUserByEmailPort;
        $this->sentVerificationEmailPort = $sentVerificationEmailPort;
    }

    public function execute(CreateUserCommand $command): UserModel
    {
        $email = new UserEmail($command->email());

        $existing = $this->getUserByEmailPort->getByEmail($email);
        if ($existing !== null) {
            throw UserAlreadyExistException::becauseEmailAlreadyExists();
        }

        $verificationToken = bin2hex(random_bytes(16));

        $user = UserModel::create(
            new UserId($command->id()),
            new UserName($command->name()),
            $email,
            UserPassword::fromPlainText($command->password()),
            $command->role(),
            $verificationToken
        );

        $savedUser = $this->saveUserPort->save($user);

        $this->sentVerificationEmailPort->sendVerificationEmail(
            $savedUser->email()->value(),
            $savedUser->name()->value(),
            $verificationToken
        );

        return $savedUser;
    }
}
