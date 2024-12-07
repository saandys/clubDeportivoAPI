<?php
namespace Src\Infrastructure\Court;

use App\Models\Court;
use App\Models\Reservation;
use Src\Domain\Entities\CourtEntity;
use Src\Domain\Repositories\ICourtRepository;

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

    public function findFreeCourts($date, $member_id, $sport_id)
    {
       // Obtener las pistas
       $courts = $this->eloquentModel->where('sport_id', $sport_id)->get();
       // franja de horas diarias
       $timeSlots = [];
        for ($hour = 8; $hour < 22; $hour++) {
            $timeSlots[] = sprintf('%02d:00:00', $hour);
        }
        $availableCourts=[];
        foreach($courts as $court)
        {
            $timeSlotCourt = $timeSlots;
            // Buscar si tiene alguna reserva en ese día
            $hours = Reservation::select('start_time')->where('court_id', $court->id)->where('date', $date)->get();

            // Si tiene 3 reservas ese día, no se continua
            if(count($hours) >= 3) return false;
            // Si no, se eliminan de la franja de horas

            foreach($hours as $hour)
            {
                $key = array_search($hour->start_time->toTimeString(), $timeSlotCourt);
                if ($key !== false) {
                    unset($timeSlotCourt[$key]);
                }
            }
            if (count($timeSlotCourt) > 0) {
                $courtArray[] = array_merge(
                    $court->toArray(),
                    ['availableHours' => $timeSlotCourt]
                );
            }

        }
        return $courtArray;
    }
}
