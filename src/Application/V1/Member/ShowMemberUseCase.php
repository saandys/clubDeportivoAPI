<?php

namespace Src\Application\V1\Member;

use Src\Domain\V1\Repositories\IMemberRepository;
use Src\Infrastructure\V1\Exceptions\NotFoundException;

final class ShowMemberUseCase
{
    private $repository;

    public function __construct(IMemberRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id)
    {
        $member = $this->repository->find($id);
        if(!$member)
        {
            throw new NotFoundException();
        }
        return $member;
    }
}
