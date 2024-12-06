<?php

namespace Src\Domain\Repositories;

use Src\Domain\Entities\SportEntity;

interface ISportRepository
{
    public function find(string $id): ?SportEntity ;
    public function save(SportEntity $user): void;
    public function update(string $id, SportEntity $user): void;
    public function delete(string $id): void;
    //
}
