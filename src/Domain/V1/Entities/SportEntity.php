<?php
namespace Src\Domain\V1\Entities;

class SportEntity
{

    protected $id;

    protected $name;



    public function __construct(
        string $name,
    ) {
        $this->name = $name;
    }

    public static function create(
        string $name,
    ): SportEntity {
        $user = new self($name);

        return $user;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
