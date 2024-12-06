<?php

namespace Src\Application\Sport;

use Src\Domain\Repositories\ISportRepository;

final class ShowSportUseCase
{
    private $repository;

    public function __construct(ISportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
       $user = $this->repository->find($id);

       return $user;
    }
}
