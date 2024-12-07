<?php
namespace Src\Domain\Entities;

class CourtEntity
{

    protected $id;

    protected $name;
    protected string $sport_id;


    public function __construct(
        string $name,
        string $sport_id
    ) {
        $this->name = $name;
        $this->sport_id = $sport_id;
    }

    public static function create(
        string $name,
        string $sport_id
    ): CourtEntity {
        $court = new self($name, $sport_id);

        return $court;
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

    public function getSport(): string
    {
        return $this->sport_id;
    }

    public function setSport(string $sport_id): void
    {
        $this->sport_id = $sport_id;
    }
}
