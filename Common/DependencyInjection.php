<?php
declare(strict_types=1);

require_once __DIR__ . '/ClassLoader.php';

final class DependencyInjection
{
    public static function boot(): void
    {
        ClassLoader::register();
        self::loadEnv();
    }

    private static function loadEnv(): void
    {
        $envPath = __DIR__ . '/../.env';
        if (!file_exists($envPath)) {
            return;
        }

        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            
            $parts = explode('=', $line, 2);
            if (count($parts) !== 2) continue;
            
            $name = trim($parts[0]);
            $value = trim($parts[1]);
            
            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

    public static function getConnection(): Connection
    {
        ClassLoader::loadClass('Connection');
        return new Connection(
            host: getenv('DB_HOST') ?: '127.0.0.1',
            port: (int)(getenv('DB_PORT') ?: 3306),
            database: getenv('DB_NAME') ?: 'crud_usuarios',
            username: getenv('DB_USER') ?: 'root',
            password: getenv('DB_PASS') ?: '',
            charset: 'utf8mb4'
        );
    }

    public static function getPdo(): PDO
    {
        return self::getConnection()->createPdo();
    }

    public static function getUserPersistenceMapper(): UserPersistenceMapper
    {
        ClassLoader::loadClass('UserPersistenceMapper');
        return new UserPersistenceMapper();
    }

    public static function getUserRepository(): UserRepositoryMySQL
    {
        ClassLoader::loadClass('UserRepositoryMySQL');
        return new UserRepositoryMySQL(self::getPdo(), self::getUserPersistenceMapper());
    }

    public static function getVerifyEmailService(): VerifyEmailService
    {
        ClassLoader::loadClass('VerifyEmailService');
        $repo = self::getUserRepository();

        return new VerifyEmailService($repo, $repo);
    }

    public static function getCreateUserUseCase(): CreateUserUseCase
    {
        ClassLoader::loadClass('CreateUserService');
        ClassLoader::loadClass('GoogleSmtpEmailAdapter');
        $repo = self::getUserRepository();
        $emailAdapter = new GoogleSmtpEmailAdapter();
        return new CreateUserService($repo, $repo, $emailAdapter);
    }

    public static function getUpdateUserUseCase(): UpdateUserUseCase
    {
        ClassLoader::loadClass('UpdateUserService');
        $repo = self::getUserRepository();
        return new UpdateUserService($repo, $repo, $repo);
    }

    public static function getDeleteUserUseCase(): DeleteUserUseCase
    {
        ClassLoader::loadClass('DeleteUserService');
        $repo = self::getUserRepository();
        return new DeleteUserService($repo, $repo);
    }

    public static function getGetUserByIdUseCase(): GetUserByIdUseCase
    {
        ClassLoader::loadClass('GetUserByIdService');
        return new GetUserByIdService(self::getUserRepository());
    }

    public static function getGetAllUsersUseCase(): GetAllUsersUseCase
    {
        ClassLoader::loadClass('GetAllUsersService');
        return new GetAllUsersService(self::getUserRepository());
    }

    public static function getLoginUseCase(): LoginUseCase
    {
        ClassLoader::loadClass('LoginService');
        return new LoginService(self::getUserRepository());
    }

    public static function getUserWebMapper(): UserWebMapper
    {
        ClassLoader::loadClass('UserWebMapper');
        return new UserWebMapper();
    }

    public static function getUserController(): UserController
    {
        ClassLoader::loadClass('UserController');
        return new UserController(
            self::getCreateUserUseCase(),
            self::getUpdateUserUseCase(),
            self::getGetUserByIdUseCase(),
            self::getGetAllUsersUseCase(),
            self::getDeleteUserUseCase(),
            self::getUserWebMapper()
        );
    }
}
