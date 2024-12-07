<?php
namespace Src\Infrastructure\Reservation;

use App\Models\Reservation;
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


}
