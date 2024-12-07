<?php

namespace Src\Application\V1\Court;

use Src\Domain\V1\Repositories\ICourtRepository;
use Src\Domain\V1\Repositories\IReservationRepository;
use Src\Infrastructure\V1\Exceptions\MaxDailyReservationsExceededException;

final class AvailablesCourtUseCase
{
    private $repository;
    private $reservationRepository;

    public function __construct(ICourtRepository $repository, IReservationRepository $reservationRepository)
    {
        $this->repository = $repository;
        $this->reservationRepository = $reservationRepository;
    }

    public function execute(string $date, string $member_id, string $sport_id)
    {
        $numberReservations = $this->reservationRepository->getNumberReservationsByMember($member_id, $date);
        if ($numberReservations >= 3) {
            throw new MaxDailyReservationsExceededException();
        }

        $availableReservations = $this->repository->findFreeCourts($date, $member_id, $sport_id);

        return $availableReservations;
    }
}
