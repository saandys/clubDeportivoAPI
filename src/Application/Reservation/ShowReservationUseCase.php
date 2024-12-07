<?php

namespace Src\Application\Reservation;

use Src\Domain\Repositories\IReservationRepository;
use Src\Infrastructure\Exceptions\NotFoundException;

final class ShowReservationUseCase
{
    private $repository;

    public function __construct(IReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id)
    {
        $reservation = $this->repository->find($id);
        if(!$reservation)
        {
            throw new NotFoundException();
        }
        return $reservation;
    }
}
