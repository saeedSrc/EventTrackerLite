<?php

namespace App\Model;

class Booking
{
    private $employee;
    private $event;
    private $participationFee;
    private $participationId;
    private $eventDate;
    private $version;

    public function __construct(Employee $employee, Event $event, $participationFee, $participationId , $eventDate, $version)
    {
        $this->employee = $employee;
        $this->event = $event;
        $this->participationFee = $participationFee;
        $this->participationId = $participationId;
        $this->eventDate = $eventDate;
        $this->version = $version;
    }
    public function getEmployee()
    {
        return $this->employee;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function getParticipationFee()
    {
        return $this->participationFee;
    }

    public function getEventDate()
    {
        return $this->eventDate;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getParticipationId()
    {
        return $this->participationId;
    }
}
