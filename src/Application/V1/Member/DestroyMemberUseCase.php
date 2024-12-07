<?php

namespace Src\Application\V1\Member;

use Src\Domain\V1\Repositories\IMemberRepository;

final class DestroyMemberUseCase
{
    private $repository;

    public function __construct(IMemberRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id)
    {
        $this->repository->delete($id);
    }
}
