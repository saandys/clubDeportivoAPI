<?php
namespace Src\Infrastructure\Court;

use App\Models\Court;
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


}
