<?php
namespace Src\Infrastructure\V1\Member;

use App\Models\Member;
use Src\Domain\V1\Entities\MemberEntity;
use Src\Domain\V1\Repositories\IMemberRepository;

class MemberEloquentRepository implements IMemberRepository
{
    public $eloquentModel;

    function __construct($model = new Member)
    {
        $this->eloquentModel = $model;
    }

    public function find(string $id): ?MemberEntity
    {
        $member = $this->eloquentModel->findOrFail($id);
        if(!$member){
            return null;
        }
        // Return Domain Member model
        return new MemberEntity(
            $member->name,
            $member->email,
            $member->phone,
        );
    }

    public function save(MemberEntity $member): void
    {
        $data = [
            'name'              => $member->getName(),
            'email'             => $member->getEmail(),
            'phone' => $member->getPhone(),
        ];

        $this->eloquentModel->create($data);
    }

    public function delete(string $id): void
    {
        $this->eloquentModel
            ->findOrFail($id)
            ->delete();
    }

    public function update(string $id, MemberEntity $member): void
    {
        $memberToUpdate = $this->eloquentModel;

        $data = [
            'name'  => $member->getName(),
            'email' => $member->getEmail(),
            'phone' => $member->getPhone()
        ];

        $memberToUpdate
            ->findOrFail($id)
            ->update($data);
    }
}
