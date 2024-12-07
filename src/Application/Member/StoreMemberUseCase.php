<?php

namespace Src\Application\Member;

use Src\Domain\Entities\MemberEntity;
use Src\Domain\Repositories\IMemberRepository;

final class StoreMemberUseCase
{
    private $repository;

    public function __construct(IMemberRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $name, string $email, string $phone): void
    {
        $user = MemberEntity::create(
            $name,
           $email,
            $phone,
           );

        $this->repository->save($user);
    }
}