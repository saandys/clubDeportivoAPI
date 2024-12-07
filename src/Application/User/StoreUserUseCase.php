<?php

namespace Src\Application\User;

use Src\Domain\Entities\UserEntity;
use Src\Domain\Repositories\IUserRepository;

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
