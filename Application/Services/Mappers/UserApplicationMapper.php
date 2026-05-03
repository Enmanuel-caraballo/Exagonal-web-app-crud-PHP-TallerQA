<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/UserModel.php';

final class UserApplicationMapper
{
    public function toArray(UserModel $user): array
    {
        return $user->toArray();
    }

    /** @return array[] */
    public function toArrayList(array $users): array
    {
        return array_map(fn(UserModel $u) => $u->toArray(), $users);
    }
}
