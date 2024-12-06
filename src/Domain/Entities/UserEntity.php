<?php
namespace Src\Domain\Entities;

class UserEntity {

    protected $id;

    protected $name;
    protected $email;
    private $password;
    private $emailVerifiedDate;
    private $rememberToken;


    public function __construct(
        string $name,
        string $email,
        string $emailVerifiedDate,
        string $password,
        string $rememberToken
    )
    {
        $this->name              = $name;
        $this->email             = $email;
        $this->emailVerifiedDate = $emailVerifiedDate;
        $this->password          = $password;
        $this->rememberToken     = $rememberToken;
    }

    public static function create(
        string $name,
        string $email,
        string $emailVerifiedDate,
        string $password,
        string $rememberToken
    ): UserEntity
    {
        $user = new self($name, $email, $emailVerifiedDate, $password, $rememberToken);

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

      public function getEmail()
      {
          return $this->email;
      }
      public function setEmail($email)
      {
          $this->email = $email;
          return $this;
      }

      public function getPassword()
      {
          return $this->password;
      }
      public function setPassword($password)
      {
          $this->password = $password;
      }


    /**
     * Get the value of emailVerifiedDate
     */
    public function getEmailVerifiedDate()
    {
        return $this->emailVerifiedDate;
    }

    /**
     * Set the value of emailVerifiedDate
     *
     * @return  self
     */
    public function setEmailVerifiedDate($emailVerifiedDate)
    {
        $this->emailVerifiedDate = $emailVerifiedDate;

        return $this;
    }

    /**
     * Get the value of rememberToken
     */
    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    /**
     * Set the value of rememberToken
     *
     * @return  self
     */
    public function setRememberToken($rememberToken)
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }
}
