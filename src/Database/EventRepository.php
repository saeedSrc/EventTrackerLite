<?php

namespace App\Database;

use App\Constants\Versions;
use App\Model\Booking;
use App\Model\Employee;
use App\Model\Event;
use App\Service\VersionComparator;



class EventRepository
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function insertBooking(Booking $booking)
    {
        $employeeId = $this->getOrCreateEmployeeId($booking->getEmployee());
        $eventId = $this->getOrCreateEventId($booking->getEvent());


        return $this->getOrCreateBookingId($employeeId, $eventId, $booking);

    }


    private function getOrCreateEmployeeId(Employee $employee): int
    {
        $mysqli = $this->connection->getMysqli();

        $name = $mysqli->real_escape_string($employee->getName());
        $email = $mysqli->real_escape_string($employee->getEmail());

        // Check if the employee already exists in the database
        $result = $mysqli->query("SELECT employee_id FROM employees WHERE employee_mail = '$email'");

        if ($result && $result->num_rows > 0) {
            // Employee already exists, return the existing ID
            $row = $result->fetch_assoc();
            return (int)$row['employee_id'];
        } else {
            // Employee doesn't exist, insert a new record and return the new ID
            $mysqli->query("INSERT INTO employees (employee_name, employee_mail) VALUES ('$name', '$email')");
            return $mysqli->insert_id;
        }
    }

    private function getOrCreateEventId(Event $event): int
    {
        $mysqli = $this->connection->getMysqli();

        $eventName = $mysqli->real_escape_string($event->getName());

        // Check if the event already exists in the database
        $result = $mysqli->query("SELECT event_id FROM events WHERE event_name = '$eventName'");

        if ($result && $result->num_rows > 0) {
            // Event already exists, return the existing ID
            $row = $result->fetch_assoc();
            return (int)$row['event_id'];
        } else {
            // Event doesn't exist, return null or any other appropriate value
            $mysqli->query("INSERT INTO events (event_name) VALUES ('$eventName')");
            return $mysqli->insert_id;
        }
    }

    private function getOrCreateBookingId($employeeId, $eventId, Booking $booking): int
    {
        $mysqli = $this->connection->getMysqli();

        $participationId = $booking->getParticipationId();

        // Check if the booking already exists in the database based on participation_id
        $result = $mysqli->query("SELECT participation_id FROM bookings WHERE participation_id = '$participationId'");

        if ($result && $result->num_rows > 0) {
            // Booking already exists, return the existing participation_id
            $row = $result->fetch_assoc();
            return (int) $row['participation_id'];
        } else {
            // Booking doesn't exist, insert a new record and return the provided participation_id
            $participationFee = $mysqli->real_escape_string($booking->getParticipationFee());
            $eventDate = $mysqli->real_escape_string($booking->getEventDate());
            $version = $mysqli->real_escape_string($booking->getVersion());
            if( VersionComparator::isVersionAfterReference($version, Versions::REFERENCE_VERSION) ) {
              $eventDate =  $this->convertToUtc($eventDate);
            }

            $query = "INSERT INTO bookings (participation_id, employee_id, event_id, participation_fee, event_date, version)
                      VALUES ('$participationId', '$employeeId', '$eventId', '$participationFee', '$eventDate', '$version')";
            $mysqli->query($query);

            return $participationId;
        }
    }



    public function fetchFilteredResults(string $query): array
    {
        $mysqli = $this->connection->getMysqli();
        $result = $mysqli->query($query);

        $filteredResults = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $filteredResults[] = $row;
            }
            $result->free();
        }

        return $filteredResults;
    }

    public function escape(string $value): string
    {
        return $this->connection->getMysqli()->real_escape_string($value);
    }

    private function convertToUtc(string $eventDate): string
    {
        // Convert event date from "Europe/Berlin" to UTC
        $dateTime = new \DateTime($eventDate, new \DateTimeZone('Europe/Berlin'));
        $dateTime->setTimezone(new \DateTimeZone('UTC'));

        return $dateTime->format('Y-m-d H:i:s');
    }

}
