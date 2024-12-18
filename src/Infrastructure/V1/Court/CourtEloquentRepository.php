<?php
namespace Src\Infrastructure\V1\Court;

use App\Models\Court;
use App\Models\Reservation;
use Src\Domain\V1\Entities\CourtEntity;
use Src\Domain\V1\Repositories\ICourtRepository;
use Src\Infrastructure\V1\Exceptions\MaxDailyReservationsExceededException;

class CourtEloquentRepository implements ICourtRepository
{
    public $eloquentModel;

    function __construct($model = new Court)
    {
        $this->eloquentModel = $model;
    }

    public function find(string $id): ?CourtEntity
    {
        $court = $this->eloquentModel->findOrFail($id);
        if(!$court){
            return null;
        }
        // Return Domain Court model
        return new CourtEntity(
            $court->name,
            $court->sport_id
        );
    }

    public function save(CourtEntity $court): void
    {
        $data = [
            'name' => $court->getName(),
            'sport_id' => $court->getSport(),
        ];

        $this->eloquentModel->create($data);
    }

    public function delete(string $id): void
    {
        $this->eloquentModel
            ->findOrFail($id)
            ->delete();
    }

    public function update(string $id, CourtEntity $court): void
    {
        $courtToUpdate = $this->eloquentModel;

        $data = [
            'name'  => $court->getName(),
            'sport_id' => $court->getSport(),
        ];

        $courtToUpdate
            ->findOrFail($id)
            ->update($data);
    }

    public function findFreeCourts(string $date, string $member_id, string $sport_id) : array
    {
       // Obtener las pistas
        $courts = $this->eloquentModel->where('sport_id', $sport_id)->get();
       // franja de horas diarias
        $timeSlots = [];
        for ($hour = 8; $hour < 22; $hour++) {
            $timeSlots[] = sprintf('%02d:00:00', $hour);
        }
        $availableCourts=[];
        foreach ($courts as $court) {
            $timeSlotCourt = $timeSlots;
            // Buscar si tiene alguna reserva en ese día
            $hours = Reservation::select('start_time')->where('court_id', $court->id)->where('date', $date)->get();

            // Si tiene 3 reservas ese día, no se continua
            if (count($hours) >= 3) {
                throw new MaxDailyReservationsExceededException();
            }
            // Si no, se eliminan de la franja de horas

            foreach ($hours as $hour) {
                $key = array_search($hour->start_time->toTimeString(), $timeSlotCourt);
                if ($key !== false) {
                    unset($timeSlotCourt[$key]);
                }
            }
            if (count($timeSlotCourt) > 0) {
                $availableCourts[] = array_merge(
                    $court->toArray(),
                    ['availableHours' => $timeSlotCourt]
                );
            }
        }
        return $availableCourts;
    }
}
