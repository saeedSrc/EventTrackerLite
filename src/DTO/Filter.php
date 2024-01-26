<?php
namespace App\DTO;
class Filter
{
    private $employeeName;
    private $eventName;
    private $eventDate;

    public function __construct($employeeName, $eventName, $eventDate)
    {
        $this->employeeName = $employeeName;
        $this->eventName = $eventName;
        $this->eventDate = $eventDate;
    }

    public function getEmployeeName()
    {
        return $this->employeeName;
    }

    public function getEventName()
    {
        return $this->eventName;
    }

    public function getEventDate()
    {
        return $this->eventDate;
    }
}
