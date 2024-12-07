<?php

namespace Src\Application\V1\Sport;

use Src\Domain\V1\Entities\SportEntity;
use Src\Domain\V1\Repositories\ISportRepository;

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
