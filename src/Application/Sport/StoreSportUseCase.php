<?php

namespace Src\Application\Sport;

use Src\Domain\Entities\SportEntity;
use Src\Domain\Repositories\ISportRepository;

final class StoreSportUseCase
{
    private $repository;

    public function __construct(ISportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $name): void
    {
        $user = SportEntity::create(
            $name,
        );

        $this->repository->save($user);
    }
}
