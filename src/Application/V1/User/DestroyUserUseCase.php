<?php

namespace Src\Application\V1\User;

use Src\Domain\V1\Repositories\IUserRepository;

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
