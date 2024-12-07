<?php

namespace Src\Application\V1\Sport;

use Src\Domain\V1\Repositories\ISportRepository;
use Src\Infrastructure\V1\Exceptions\NotFoundException;

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
