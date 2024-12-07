<?php
namespace Src\Infrastructure\Sport;

use App\Models\Sport;
use Src\Domain\Entities\SportEntity;
use Src\Domain\Repositories\ISportRepository;

class SportEloquentRepository implements ISportRepository
{
    public $eloquentModel;

    function __construct($model = new Sport)
    {
        $this->eloquentModel = $model;
    }

    public function find(string $id): ?SportEntity
    {
        $sport = $this->eloquentModel->findOrFail($id);

        // Return Domain Sport model
        return new SportEntity(
            $sport->name,
        );
    }

    public function save(SportEntity $sport): void
    {
        $data = [
            'name'              => $sport->getName(),

        ];

        $this->eloquentModel->create($data);
    }

    public function delete(string $id): void
    {
        $this->eloquentModel
            ->findOrFail($id)
            ->delete();
    }

    public function update(string $id, SportEntity $sport): void
    {
        $sportToUpdate = $this->eloquentModel;

        $data = [
            'name'  => $sport->getName(),

        ];

        $sportToUpdate
            ->findOrFail($id)
            ->update($data);
    }
}
