<?php

namespace Src\Domain\V1\Repositories;

use Src\Domain\V1\Entities\SportEntity;

interface ISportRepository
{
    public function find(string $id): ?SportEntity;
    public function save(SportEntity $user): void;
    public function update(string $id, SportEntity $user): void;
    public function delete(string $id): void;
    //
}
