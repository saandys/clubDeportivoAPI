<?php

namespace Src\Application\V1\User;

use Src\Domain\V1\Repositories\IUserRepository;

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
