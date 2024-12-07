<?php

namespace Src\Application\Reservation;

use Src\Domain\Entities\ReservationEntity;
use Src\Domain\Repositories\IReservationRepository;

final class StoreReservationUseCase
{
    private $repository;

    public function __construct(IReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $date, string $start_time, string $end_time, string $member_id, string $court_id): void
    {
        $user = ReservationEntity::create(
            $date,
         $start_time,
         $end_time,
         $member_id,
         $court_id,
           );

        $this->repository->save($user);
    }
}
