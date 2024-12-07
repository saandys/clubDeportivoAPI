<?php
namespace Src\Domain\Entities;

class ReservationEntity {

    protected $id;

    protected $date;
    protected $start_time;
    protected $end_time;
    protected string $member_id;
    protected string $court_id;


    public function __construct(
        string $date,
        string $start_time,
        string $end_time,
        string $member_id,
        string $court_id,
    )
    {
        $this->date = $date;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->member_id = $member_id;
        $this->court_id = $court_id;
    }

    public static function create(
        string $date,
        string $start_time,
        string $end_time,
        string $member_id,
        string $court_id,
    ): ReservationEntity
    {
        $reservation = new self( $date, $start_time, $end_time, $member_id, $court_id);

        return $reservation;
    }

    public function getId()
    {
      return $this->id;
    }
    public function setId($id)
    {
      $this->id = $id;
    }


    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of start_time
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * Set the value of start_time
     *
     * @return  self
     */
    public function setStartTime($start_time)
    {
        $this->start_time = $start_time;

        return $this;
    }

    /**
     * Get the value of end_time
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * Set the value of end_time
     *
     * @return  self
     */
    public function setEndTime($end_time)
    {
        $this->end_time = $end_time;

        return $this;
    }

    /**
     * Get the value of member_id
     */
    public function getMember()
    {
        return $this->member_id;
    }

    /**
     * Set the value of member_id
     *
     * @return  self
     */
    public function setMember($member_id)
    {
        $this->member_id = $member_id;

        return $this;
    }

    /**
     * Get the value of court_id
     */
    public function getCourt()
    {
        return $this->court_id;
    }

    /**
     * Set the value of court_id
     *
     * @return  self
     */
    public function setCourt($court_id)
    {
        $this->court_id = $court_id;

        return $this;
    }
}
