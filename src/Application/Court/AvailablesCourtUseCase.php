<?php

namespace Src\Application\Court;

use Src\Domain\Repositories\ICourtRepository;
use Src\Domain\Repositories\IReservationRepository;
use Src\Infrastructure\Exceptions\MaxDailyReservationsExceededException;

final class AvailablesCourtUseCase
{
    private $repository;
    private $reservationRepository;

    public function __construct(ICourtRepository $repository, IReservationRepository $reservationRepository)
    {
        $this->repository = $repository;
        $this->reservationRepository = $reservationRepository;
    }

    public function execute($date, $member_id, $sport_id)
    {
        $numberReservations = $this->reservationRepository->getNumberReservationsByMember($member_id, $date);
        if($numberReservations >= 3) throw new MaxDailyReservationsExceededException();

       $availableReservations = $this->repository->findFreeCourts($date, $member_id, $sport_id);

       return $availableReservations;
    }
}
