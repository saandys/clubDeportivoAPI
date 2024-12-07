<?php

namespace Src\Application\V1\Reservation;

use Src\Domain\V1\Repositories\IReservationRepository;
use Src\Infrastructure\V1\Exceptions\NotFoundException;

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
