<?php

namespace Src\Application\Reservation;

use Src\Domain\Repositories\IReservationRepository;

final class DestroyReservationUseCase
{
    private $repository;

    public function __construct(IReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
        $this->repository->delete($id);
    }
}
