<?php

namespace Src\Application\V1\User;

use Src\Domain\V1\Entities\UserEntity;
use Src\Domain\V1\Repositories\IUserRepository;

final class UpdateUserUseCase
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id, string $name, string $email, string $password): void
    {
        $user = UserEntity::create(
            $name,
            $email,
            '',
            $password,
            ''
        );

        $this->repository->update($id, $user);
    }
}
