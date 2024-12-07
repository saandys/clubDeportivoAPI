<?php

namespace Src\Domain\V1\Repositories;

use Src\Domain\V1\Entities\ReservationEntity;
use Src\Domain\V1\Entities\SportEntity;

interface IReservationRepository
{
    public function find(string $id): ?ReservationEntity;
    public function save(ReservationEntity $court): void;
    public function update(string $id, ReservationEntity $court): void;
    public function delete(string $id): void;
    public function verifyDisponibilityCourt($court_id, $start_time, $date);
    public function getNumberReservationsByMember($member_id, $date);
    public function verifyHourByMember($member_id, $date, $start_time);
    public function getAllReservationsByDay($date);
    //
}
