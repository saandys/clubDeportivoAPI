<?php

namespace Src\Application\V1\Court;

use Src\Domain\V1\Entities\CourtEntity;
use Src\Domain\V1\Repositories\ICourtRepository;

final class UpdateCourtUseCase
{
    private $repository;

    public function __construct(ICourtRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id, string $name, string $sport_id): void
    {
        $court = CourtEntity::create(
            $name,
            $sport_id
        );

        $this->repository->update($id, $court);
    }
}
