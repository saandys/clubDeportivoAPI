<?php

namespace Src\Application\Court;

use Src\Domain\Repositories\ICourtRepository;

final class ShowCourtUseCase
{
    private $repository;

    public function __construct(ICourtRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id)
    {
       $user = $this->repository->find($id);

       return $user;
    }
}
