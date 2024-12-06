<?php

namespace Src\Application\Sport;

use Src\Domain\Entities\SportEntity;
use Src\Domain\Repositories\ISportRepository;

final class UpdateSportUseCase
{
    private $repository;

    public function __construct(ISportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id, string $name): void
    {
        $sport = SportEntity::create(
            $name,
           );

        $this->repository->update($id, $sport);
    }
}
