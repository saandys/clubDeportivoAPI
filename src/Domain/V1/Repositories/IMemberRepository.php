<?php

namespace Src\Domain\V1\Repositories;

use Src\Domain\V1\Entities\MemberEntity;

interface IMemberRepository
{
    public function find(string $id): ?MemberEntity;
    public function save(MemberEntity $user): void;
    public function update(string $id, MemberEntity $user): void;
    public function delete(string $id): void;
    //
}
