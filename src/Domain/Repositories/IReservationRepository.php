<?php

namespace Src\Domain\Repositories;

use Src\Domain\Entities\ReservationEntity;
use Src\Domain\Entities\SportEntity;

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
