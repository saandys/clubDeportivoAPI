<?php

namespace Src\Application\V1\Member;

use Src\Domain\V1\Entities\MemberEntity;
use Src\Domain\V1\Repositories\IMemberRepository;

final class UpdateMemberUseCase
{
    private $repository;

    public function __construct(IMemberRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id, string $name, string $email, string $phone): void
    {
        $user = MemberEntity::create(
            $name,
            $email ?? '',
            $phone,
        );

        $this->repository->update($id, $user);
    }
}
