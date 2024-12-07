<?php

namespace Src\Application\V1\Sport;

use Src\Domain\V1\Entities\SportEntity;
use Src\Domain\V1\Repositories\ISportRepository;

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
