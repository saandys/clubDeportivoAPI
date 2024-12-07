<?php

namespace Src\Application\V1\User;

use Src\Domain\V1\Repositories\IUserRepository;
use Src\Infrastructure\V1\Exceptions\NotFoundException;

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
