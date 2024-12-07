<?php

namespace Src\Application\Court;

use Src\Domain\Entities\CourtEntity;
use Src\Domain\Repositories\ICourtRepository;

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
