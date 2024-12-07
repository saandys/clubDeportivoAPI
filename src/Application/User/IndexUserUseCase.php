<?php

namespace Src\Application\User;

use Src\Domain\Repositories\IUserRepository;

final class IndexUserUseCase
{
    private $repository;

    public function _construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
    }
}
