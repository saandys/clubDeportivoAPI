<?php

namespace Src\Application\V1\Reservation;

use Src\Domain\V1\Repositories\IReservationRepository;

final class DestroyReservationUseCase
{
    private $repository;

    public function __construct(IReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id)
    {
        $this->repository->delete($id);
    }
}
