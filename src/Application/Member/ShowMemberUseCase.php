<?php

namespace Src\Application\Member;

use Src\Domain\Repositories\IMemberRepository;
use Src\Infrastructure\Exceptions\NotFoundException;

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
