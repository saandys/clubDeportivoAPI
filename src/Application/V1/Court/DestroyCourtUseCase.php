<?php

namespace Src\Application\V1\Court;

use Src\Domain\V1\Repositories\ICourtRepository;

final class DestroyCourtUseCase
{
    private $repository;

    public function __construct(ICourtRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id)
    {
        $this->repository->delete($id);
    }
}
