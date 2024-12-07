<?php

namespace Src\Application\Reservation;

use Src\Domain\Repositories\IReservationRepository;

final class ShowReservationUseCase
{
    private $repository;

    public function __construct(IReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
       $user = $this->repository->find($id);

       return $user;
    }
}
