<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dto/CreateUserRequest.php';
require_once __DIR__ . '/../Dto/UpdateUserRequest.php';
require_once __DIR__ . '/../Dto/UserResponse.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/CreateUserCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/UpdateUserCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/DeleteUserCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Queries/GetUserByIdQuery.php';
require_once __DIR__ . '/../../../../../Domain/Models/UserModel.php';

final class UserWebMapper
{
    public function fromCreateRequestToCommand(CreateUserWebRequest $request): CreateUserCommand
    {
        return new CreateUserCommand(
            $request->getId(),
            $request->getName(),
            $request->getEmail(),
            $request->getPassword(),
            $request->getRole()
        );
    }

    public function fromUpdateRequestToCommand(UpdateUserWebRequest $request): UpdateUserCommand
    {
        return new UpdateUserCommand(
            $request->getId(),
            $request->getName(),
            $request->getEmail(),
            $request->getPassword(),
            $request->getRole(),
            $request->getStatus()
        );
    }

    public function fromIdToGetByIdQuery(string $id): GetUserByIdQuery
    {
        return new GetUserByIdQuery($id);
    }

    public function fromIdToDeleteCommand(string $id): DeleteUserCommand
    {
        return new DeleteUserCommand($id);
    }

    public function fromModelToResponse(UserModel $user): UserResponse
    {
        return new UserResponse(
            $user->id()->value(),
            $user->name()->value(),
            $user->email()->value(),
            $user->rol(),      // getter es rol() en este proyecto
            $user->status()
        );
    }

    /**
     * @param UserModel[] $users
     * @return UserResponse[]
     */
    public function fromModelsToResponses(array $users): array
    {
        $responses = array();
        foreach ($users as $user) {
            $responses[] = $this->fromModelToResponse($user);
        }
        return $responses;
    }
}
