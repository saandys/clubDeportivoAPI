<?php

namespace Src\Application\V1\Court;

use Src\Domain\V1\Repositories\ICourtRepository;
use Src\Infrastructure\V1\Exceptions\NotFoundException;

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
