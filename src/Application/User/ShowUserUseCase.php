<?php

namespace Src\Application\User;

use Src\Domain\Repositories\IUserRepository;
use Src\Infrastructure\Exceptions\NotFoundException;

final class ShowUserUseCase
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id)
    {
        $user = $this->repository->find($id);
        if(!$user)
        {
            throw new NotFoundException();
        }
        return $user;
    }
}
