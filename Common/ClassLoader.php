<?php
declare(strict_types=1);

final class ClassLoader
{
    /** @var array<string, string> */
    private static array $classMap = array(
        // Domain - Exceptions
        'InvalidUserEmailException'    => 'Domain/Exceptions/InvalidUserEmailException.php',
        'InvalidUserIdException'       => 'Domain/Exceptions/InvalidUserIdException.php',
        'InvalidUserNameException'     => 'Domain/Exceptions/InvalidUserNameException.php',
        'IvalidPasswordException'      => 'Domain/Exceptions/IvalidPasswordException.php',
        'InvalidUserRolException'      => 'Domain/Exceptions/InvalidUserRolException.php',
        'InvalidUserStatusException'   => 'Domain/Exceptions/InvalidUserStatusException.php',
        'UserAlreadyExistException'    => 'Domain/Exceptions/UserAlreadyExistException.php',
        'UserNotFoundException'        => 'Domain/Exceptions/UserNotFoundException.php',
        'InvalidCredentialsException'  => 'Domain/Exceptions/InvalidCredentialsException.php',
        // Domain - Enums
        'UserRolEnum'                  => 'Domain/Enums/UserRolEnum.php',
        'UserStatusEnum'               => 'Domain/Enums/UserStatusEnum.php',
        // Domain - ValueObjects
        'UserId'                       => 'Domain/ValueObjects/UserId.php',
        'UserName'                     => 'Domain/ValueObjects/UserName.php',
        'UserEmail'                    => 'Domain/ValueObjects/UserEmail.php',
        'UserPassword'                 => 'Domain/ValueObjects/UserPassword.php',
        // Domain - Models
        'UserModel'                    => 'Domain/Models/UserModel.php',
        // Application - Ports In
        'CreateUserUseCase'            => 'Application/Ports/In/CreateUserUseCase.php',
        'UpdateUserUseCase'            => 'Application/Ports/In/UpdateUserUseCase.php',
        'GetUserByIdUseCase'           => 'Application/Ports/In/GetUserByIdUseCase.php',
        'GetAllUsersUseCase'           => 'Application/Ports/In/GetAllUsersUseCase.php',
        'DeleteUserUseCase'            => 'Application/Ports/In/DeleteUserUseCase.php',
        'LoginUseCase'                 => 'Application/Ports/In/LoginUseCase.php',
        // Application - Ports Out
        'SaveUserPort'                 => 'Application/Ports/Out/SaveUserPort.php',
        'UpdateUserPort'               => 'Application/Ports/Out/UpdateUserPort.php',
        'GetUserByIdPort'              => 'Application/Ports/Out/GetUserByIdPort.php',
        'GetUserByEmailPort'           => 'Application/Ports/Out/GetUserByEmailPort.php',
        'GetAllUsersPort'              => 'Application/Ports/Out/GetAllUsersPort.php',
        'DeleteUserPort'               => 'Application/Ports/Out/DeleteUserPort.php',
        'SentVerificationEmailPort'    => 'Application/Ports/Out/SentVerificationEmailPort.php',
        // Application - Commands
        'CreateUserCommand'            => 'Application/Services/Dto/Commands/CreateUserCommand.php',
        'UpdateUserCommand'            => 'Application/Services/Dto/Commands/UpdateUserCommand.php',
        'DeleteUserCommand'            => 'Application/Services/Dto/Commands/DeleteUserCommand.php',
        'LoginCommand'                 => 'Application/Services/Dto/Commands/LoginCommand.php',
        // Application - Queries
        'GetUserByIdQuery'             => 'Application/Services/Dto/Queries/GetUserByIdQuery.php',
        'GetAllUsersQuery'             => 'Application/Services/Dto/Queries/GetAllUsersQuery.php',
        // Application - Services
        'VerifyEmailService'           => 'Application/Services/VerifyEmailService.php',
        'CreateUserService'            => 'Application/Services/CreateUserService.php',
        'UpdateUserService'            => 'Application/Services/UpdateUserService.php',
        'GetUserByIdService'           => 'Application/Services/GetUserByIdService.php',
        'GetAllUsersService'           => 'Application/Services/GetAllUsersService.php',
        'DeleteUserService'            => 'Application/Services/DeleteUserService.php',
        'LoginService'                 => 'Application/Services/LoginService.php',
        // Application - Mappers
        'UserApplicationMapper'        => 'Application/Services/Mappers/UserApplicationMapper.php',
        // Infrastructure - Config
        'Connection'                   => 'Infraestructure/Adapters/Persistence/MySQL/Config/Connection.php',
        // Infrastructure - Adapters Email
        'GoogleSmtpEmailAdapter'       => 'Infraestructure/Adapters/Email/GoogleSmtpEmailAdapter.php',
        // Infrastructure - DTO & Entity
        'UserPersistenceDto'           => 'Infraestructure/Adapters/Persistence/MySQL/Dto/UserPersistenceDto.php',
        'UserEntity'                   => 'Infraestructure/Adapters/Persistence/MySQL/Entity/UserEntity.php',
        // Infrastructure - Mapper & Repository
        'UserPersistenceMapper'        => 'Infraestructure/Adapters/Persistence/MySQL/Mapper/UserPersistenceMapper.php',
        'UserRepositoryMySQL'          => 'Infraestructure/Adapters/Persistence/MySQL/Repository/UserRepositoryMySQL.php',
        // Entrypoints - DTOs Web
        'CreateUserWebRequest'         => 'Infraestructure/Entrypoints/Web/Controllers/Dto/CreateUserRequest.php',
        'UpdateUserWebRequest'         => 'Infraestructure/Entrypoints/Web/Controllers/Dto/UpdateUserRequest.php',
        'LoginWebRequest'              => 'Infraestructure/Entrypoints/Web/Controllers/Dto/LoginWebRequest.php',
        'UserResponse'                 => 'Infraestructure/Entrypoints/Web/Controllers/Dto/UserResponse.php',
        // Entrypoints - Mapper, Controller & Routes
        'UserWebMapper'                => 'Infraestructure/Entrypoints/Web/Controllers/Mapper/UserWebMapper.php',
        'UserController'               => 'Infraestructure/Entrypoints/Web/Controllers/UserController.php',
        'WebRoutes'                    => 'Infraestructure/Entrypoints/Web/Controllers/Config/WebRoutes.php',
        // Entrypoints - Presentation
        'View'                         => 'Infraestructure/Entrypoints/Web/Presentation/View.php',
        'Flash'                        => 'Infraestructure/Entrypoints/Web/Presentation/Flash.php',
        // Common
        'DependencyInjection'          => 'Common/DependencyInjection.php',
    );

    public static function register(): void
    {
        spl_autoload_register(array(self::class, 'loadClass'));
    }

    public static function loadClass(string $className): void
    {
        if (!isset(self::$classMap[$className])) {
            return;
        }

        $baseDir  = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        $filePath = $baseDir . str_replace('/', DIRECTORY_SEPARATOR, self::$classMap[$className]);

        if (!file_exists($filePath)) {
            throw new RuntimeException(
                sprintf('No se encontró el archivo para la clase %s en %s', $className, $filePath)
            );
        }

        require_once $filePath;
    }
}
