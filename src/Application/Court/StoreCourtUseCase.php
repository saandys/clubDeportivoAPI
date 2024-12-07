<?php

namespace Src\Application\Court;

use Src\Domain\Entities\CourtEntity;
use Src\Domain\Repositories\ICourtRepository;
use Src\Domain\Repositories\ISportRepository;

final class StoreCourtUseCase
{
    private $repository;
    private $sportRepository;

    public function __construct(ICourtRepository $repository, ISportRepository $sportRepository)
    {
        $this->repository = $repository;
    }

    public function execute(string $name, string $sport_id): void
    {
        // Buscar el deporte

        $user = CourtEntity::create(
            $name,
            $sport_id
        );

        $this->repository->save($user);
    }
}
