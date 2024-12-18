<?php
namespace Src\Infrastructure\V1\User;

use App\Models\User;
use Src\Domain\V1\Entities\UserEntity;
use Src\Domain\V1\Repositories\IUserRepository;

class UserEloquentRepository implements IUserRepository
{
    public $eloquentModel;

    function __construct($model = new User)
    {
        $this->eloquentModel = $model;
    }

    public function find(string $id): ?UserEntity
    {
        $user = $this->eloquentModel->findOrFail($id);
        if(!$user){
            return null;
        }

        // Return Domain User model
        return new UserEntity(
            $user->name,
            $user->email,
            $user->email_verified_at ?? '',
            $user->password,
            $user->remember_token  ?? ''
        );
    }

    public function save(UserEntity $user): void
    {
        $data = [
            'name'              => $user->getName(),
            'email'             => $user->getEmail(),
            'email_verified_at' => $user->getEmailVerifiedDate(),
            'password'          => $user->getPassword(),
            'remember_token'    => $user->getRememberToken(),
        ];

        $this->eloquentModel->create($data);
    }

    public function delete(string $id): void
    {
        $this->eloquentModel
            ->findOrFail($id)
            ->delete();
    }

    public function update(string $id, UserEntity $user): void
    {
        $userToUpdate = $this->eloquentModel;

        $data = [
            'name'  => $user->getName(),
            'email' => $user->getEmail(),
        ];

        $userToUpdate
            ->findOrFail($id)
            ->update($data);
    }

    public function login(string $email): User
    {
        return $this->eloquentModel->where('email', $email)->first();

    }
}
