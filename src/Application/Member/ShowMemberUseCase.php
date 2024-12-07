<?php

namespace Src\Application\Member;

use Src\Domain\Repositories\IMemberRepository;

final class ShowMemberUseCase
{
    private $repository;

    public function __construct(IMemberRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
        $user = $this->repository->find($id);

        return $user;
    }
}
