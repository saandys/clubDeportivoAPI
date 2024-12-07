<?php

namespace Src\Application\V1\User;

use Src\Domain\V1\Entities\UserEntity;
use Src\Domain\V1\Repositories\IUserRepository;

final class StoreUserUseCase
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $name, string $email, string $password): void
    {
        $user = UserEntity::create(
            $name,
            $email,
            '',
            $password,
            ''
        );

        $this->repository->save($user);
    }
}
