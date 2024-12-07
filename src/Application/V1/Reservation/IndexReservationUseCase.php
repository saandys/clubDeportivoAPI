<?php

namespace Src\Application\V1\Reservation;

use Src\Domain\V1\Repositories\IReservationRepository;

final class IndexReservationUseCase
{
    private $repository;

    public function __construct(IReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $date)
    {
        $reservations = $this->repository->getAllReservationsByDay($date);

        return $reservations->toArray();
    }
}
