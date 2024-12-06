<?php

namespace Src\Application\User;

use Src\Domain\Repositories\IUserRepository;

final class DestroyUserUseCase
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
        $this->repository->delete($id);
    }
}
