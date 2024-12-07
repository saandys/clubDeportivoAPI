<?php

namespace Src\Application\User;

use Src\Domain\Repositories\IUserRepository;

final class ShowUserUseCase
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
        $user = $this->repository->find($id);

        return $user;
    }
}
