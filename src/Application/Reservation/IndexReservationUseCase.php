<?php

namespace Src\Application\Reservation;

use Src\Domain\Repositories\IReservationRepository;

final class IndexReservationUseCase
{
    private $repository;

    public function __construct(IReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($date)
    {
        $reservations = $this->repository->getAllReservationsByDay($date);

        return $reservations->toArray();
    }
}
