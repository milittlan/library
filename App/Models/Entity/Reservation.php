<?php

namespace App\Models\Entity;


class Reservation extends \App\Models\ReservationServices {

    private $id;
    private $userid;
    private $bookid;
    private $datecreated;
    private $dateend;
    private $description;
    private $status;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $userid
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid): void
    {
        $this->userid = $userid;
    }

    /**
     * @return mixed
     */
    public function getBookid()
    {
        return $this->bookid;
    }

    /**
     * @param mixed $bookid
     */
    public function setBookid($bookid): void
    {
        $this->bookid = $bookid;
    }

    /**
     * @return mixed
     */
    public function getDatecreated()
    {
        return $this->datecreated;
    }

    /**
     * @param mixed $datecreated
     */
    public function setDatecreated($datecreated): void
    {
        $this->datecreated = $datecreated;
    }

    /**
     * @return mixed
     */
    public function getDateend()
    {
        return $this->dateend;
    }

    /**
     * @param mixed $dateend
     */
    public function setDateend($dateend): void
    {
        $this->dateend = $dateend;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }


}