<?php

namespace Src\Application\Sport;

use Src\Domain\Repositories\ISportRepository;

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
