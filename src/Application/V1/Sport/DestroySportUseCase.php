<?php

namespace Src\Application\V1\Sport;

use Src\Domain\V1\Repositories\ISportRepository;

final class DestroySportUseCase
{
    private $repository;

    public function __construct(ISportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
        $this->repository->delete($id);
    }
}
