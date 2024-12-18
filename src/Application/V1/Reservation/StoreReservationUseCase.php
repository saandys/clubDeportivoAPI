<?php

namespace Src\Application\V1\Reservation;

use Cron\HoursField;
use Src\Domain\V1\Entities\ReservationEntity;
use Src\Domain\V1\Repositories\IReservationRepository;
use Src\Infrastructure\V1\Exceptions\CourtAlreadyBookedException;
use Src\Infrastructure\V1\Exceptions\HourExceedeedTime;
use Src\Infrastructure\V1\Exceptions\MemberAlreadyHasReservationException;
use Src\Infrastructure\V1\Exceptions\MaxDailyReservationsExceededException;
use Src\Infrastructure\V1\Exceptions\MaxTimeBetweenHours;

final class StoreReservationUseCase
{
    private $repository;

    public function __construct(IReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $date, string $start_time, string $end_time, string $member_id, string $court_id): void
    {

        // Validate hours
        $correctTime = $this->verifyHours($start_time, $end_time);
        if (!$correctTime) {
            throw new MaxTimeBetweenHours();
        }

        $exist = $this->repository->verifyDisponibilityCourt($court_id, $start_time, $date);

        if (!$exist) {
            throw new CourtAlreadyBookedException();
        }

        $numberReservations = $this->repository->getNumberReservationsByMember($member_id, $date);
        if ($numberReservations >= 3) {
            throw new MaxDailyReservationsExceededException();
        }

        $exist = $this->repository->verifyHourByMember($member_id, $date, $start_time);
        if ($exist) {
            throw new MemberAlreadyHasReservationException();
        }

        $reservation = ReservationEntity::create(
            $date,
            $start_time,
            $end_time,
            $member_id,
            $court_id,
        );

        $this->repository->save($reservation);
    }

    public function verifycorrectTime($start_time)
    {
        $startBoundary = \Carbon\Carbon::createFromTimeString('08:00');
        $endBoundary = \Carbon\Carbon::createFromTimeString('21:00');
        $currentTime = \Carbon\Carbon::createFromTimeString($start_time);

        return $currentTime->between($startBoundary, $endBoundary);
    }

    public function verifyHours($start_time, $end_time)
    {
        $validateStartTime = $this->verifycorrectTime($start_time);
        if (!$validateStartTime) {
            throw new HourExceedeedTime();
        }

        $start = \Carbon\Carbon::createFromTimeString($start_time);
        $end = \Carbon\Carbon::createFromTimeString($end_time);
        return $start->diffInHours($end) == 1;
    }
}
