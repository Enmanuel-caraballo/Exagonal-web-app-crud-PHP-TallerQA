<?php
declare(strict_types=1);

interface GetAllUsersPort
{
    /** @return UserModel[] */
    public function getAll(): array;
}
