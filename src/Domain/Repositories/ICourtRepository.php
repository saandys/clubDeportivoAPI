<?php

namespace Src\Domain\Repositories;

use Src\Domain\Entities\CourtEntity;
use Src\Domain\Entities\SportEntity;

interface ICourtRepository
{
    public function find(string $id): ?CourtEntity ;
    public function save(CourtEntity $court): void;
    public function update(string $id, CourtEntity $court): void;
    public function delete(string $id): void;
    public function findFreeCourts($date, $member_id, $sport_id);
    //
}
