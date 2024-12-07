<?php

namespace Src\Application\Sport;

use Src\Domain\Repositories\ISportRepository;
use Src\Infrastructure\Exceptions\NotFoundException;

final class ShowSportUseCase
{
    private $repository;

    public function __construct(ISportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id)
    {
        $sport = $this->repository->find($id);
        if(!$sport)
        {
            throw new NotFoundException();
        }
        return $sport;
    }
}
