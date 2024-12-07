<?php

namespace Src\Application\Court;

use Src\Domain\Repositories\ICourtRepository;
use Src\Infrastructure\Exceptions\NotFoundException;

final class ShowCourtUseCase
{
    private $repository;

    public function __construct(ICourtRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id)
    {
        $court = $this->repository->find($id);
        if(!$court)
        {
            throw new NotFoundException();
        }
        return $court;
    }
}
