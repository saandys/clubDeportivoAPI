<?php
namespace Src\Domain\V1\Entities;

class MemberEntity
{

    protected $id;

    protected $name;
    protected $email;
    private $phone;


    public function __construct(
        string $name,
        string $email,
        string $phone,
    ) {
        $this->name              = $name;
        $this->email             = $email;
        $this->phone          = $phone;
    }

    public static function create(
        string $name,
        string $email,
        string $phone,
    ): MemberEntity {
        $member = new self($name, $email, $phone);

        return $member;
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

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }


    /**
     * Get the value of phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }
}
