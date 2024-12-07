<?php

namespace Src\Application\V1\User;

use Illuminate\Support\Facades\Hash;
use Src\Domain\V1\Repositories\IUserRepository;
use Src\Infrastructure\V1\Exceptions\NotFoundException;

final class LoginUserUseCase
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $email, string $password)
    {
        $user = $this->repository->login($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $token = $user->createToken('access_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
}
