<?php namespace Src\Infrastructure\Reservation;

use App\Models\Reservation;
use Ramsey\Uuid\Type\Integer;
use Src\Domain\Entities\ReservationEntity;
use Src\Domain\Repositories\IReservationRepository;

class ReservationEloquentRepository implements IReservationRepository
{
    public $eloquentModel;

    function __construct($model = new Reservation)
    {
        $this->eloquentModel = $model;
    }

    public function find(string $id): ?ReservationEntity
    {
        $reservation = $this->eloquentModel->findOrFail($id);
        if(!$reservation){
            return null;
        }
        // Return Domain Reservation model
        return new ReservationEntity(
            $reservation->date,
            $reservation->start_time,
            $reservation->end_time,
            $reservation->member_id,
            $reservation->court_id,
        );
    }

    public function save(ReservationEntity $reservation): void
    {
        $data = [
            'court_id' => $reservation->getCourt(),
            'member_id' => $reservation->getMember(),
            'date' => $reservation->getDate(),
            'start_time' => $reservation->getStartTime(),
            'end_time' => $reservation->getEndTime(),
        ];

        $this->eloquentModel->create($data);
    }

    public function delete(string $id): void
    {
        $this->eloquentModel
            ->findOrFail($id)
            ->delete();
    }

    public function update(string $id, ReservationEntity $reservation): void
    {
        $reservationToUpdate = $this->eloquentModel;

        $data = [
            'court_id' => $reservation->getCourt(),
            'member_id' => $reservation->getMember(),
            'date' => $reservation->getDate(),
            'start_time' => $reservation->getStartTime(),
            'end_time' => $reservation->getEndTime(),

        ];

        $reservationToUpdate
            ->findOrFail($id)
            ->update($data);
    }

    public function verifyDisponibilityCourt($court_id, $start_time, $date): bool
    {
        $reservation = $this->eloquentModel->where('court_id', $court_id)
            ->where('start_time', $start_time)
            ->where('date', $date)->first();

        if ($reservation) {
            return false;
        }
        return true;
    }

    public function getNumberReservationsByMember($member_id, $date) : mixed
    {
        $number = $this->eloquentModel->where('member_id', $member_id)
            ->where('date', $date)->get()->count();
        return $number;
    }

    public function verifyHourByMember($member_id, $date, $start_time): bool
    {
        $exist = $this->eloquentModel->where('member_id', $member_id)
            ->where('date', $date)
            ->where('start_time', $start_time)->first();

        if (!$exist) {
            return false;
        }
        return true;
    }

    public function getAllReservationsByDay($date): mixed
    {
        $reservations = $this->eloquentModel
        ::with(['member', 'court', 'court.sport'])
            ->where('date', $date)
            ->paginate(15);

            return $reservations;
    }
}
