<?php

namespace Src\Application\Court;

use Src\Domain\Repositories\ICourtRepository;

final class DestroyCourtUseCase
{
    private $repository;

    public function __construct(ICourtRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
        $this->repository->delete($id);
    }
}
