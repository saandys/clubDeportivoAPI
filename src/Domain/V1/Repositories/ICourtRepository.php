<?php

namespace Src\Domain\V1\Repositories;

use Src\Domain\V1\Entities\CourtEntity;
use Src\Domain\V1\Entities\SportEntity;

interface ICourtRepository
{
    public function find(string $id): ?CourtEntity;
    public function save(CourtEntity $court): void;
    public function update(string $id, CourtEntity $court): void;
    public function delete(string $id): void;
    public function findFreeCourts(string $date, string $member_id, string $sport_id) : array;    //
}
