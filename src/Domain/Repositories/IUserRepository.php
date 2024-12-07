<?php

namespace Src\Domain\Repositories;

use App\Models\User;
use Src\Domain\Entities\UserEntity;

interface IUserRepository
{
    public function find(string $id): ?UserEntity;
    public function save(UserEntity $user): void;
    public function update(string $id, UserEntity $user): void;
    public function delete(string $id): void;
    public function login(string $email): User;
    //
}
