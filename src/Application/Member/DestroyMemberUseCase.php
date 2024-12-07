<?php

namespace Src\Application\Member;

use Src\Domain\Repositories\IMemberRepository;

final class DestroyMemberUseCase
{
    private $repository;

    public function __construct(IMemberRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
        $this->repository->delete($id);
    }
}
