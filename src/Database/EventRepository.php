<?php

namespace App\Database;

use App\Constants\Versions;
use App\DTO\Filter;
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

    public function insertBooking(Booking $booking):int
    {
        $employeeId = $this->getOrCreateEmployeeId($booking->getEmployee());
        $eventId = $this->getOrCreateEventId($booking->getEvent());

        return $this->getOrCreateBookingId($employeeId, $eventId, $booking);

    }

    private function getOrCreateEmployeeId(Employee $employee): int
    {
        $query = Queries::getEmployeeId();
        $employeeId = $this->prepareAndFetch($query, "s", [$employee->getEmail()]);

        if ($employeeId) {
            // Employee already exists, return the existing ID
            return $employeeId;
        } else {
            // Employee doesn't exist, insert a new record and return the new ID
            $query = Queries::createEmployee();
            return $this->prepareAndFetch($query, "ss", [$employee->getName(), $employee->getEmail()], true);
        }
    }

    private function getOrCreateEventId(Event $event): int
    {
        $query = Queries::getEventId();
         $eventId  = $this->prepareAndFetch($query, "s", [$event->getName()]);
        if ($eventId) {
            // Event already exists, return the existing ID
            return $eventId;
        } else {
            // Event doesn't exist, return null or any other appropriate value
             $query = Queries::createEvent();
            return $this->prepareAndFetch($query, "s", [$event->getName()], true);
        }
    }

    private function getOrCreateBookingId($employeeId, $eventId, Booking $booking): int
    {
        $query = Queries::getBookingId();
        $participationId = $this->prepareAndFetch($query, "s", [$booking->getParticipationId()]);

        if ($participationId) {
            return $participationId;
        } else {
            // Booking doesn't exist, insert a new record and return the provided participation_id
            $eventDate = $booking->getEventDate();
            if (VersionComparator::isVersionAfterReference($booking->getVersion(), Versions::REFERENCE_VERSION)) {
                $eventDate = $this->convertToUtc($eventDate);
            }

            $query = Queries::createdBooking();
            return $this->prepareAndFetch($query, "iiisss",
                [$booking->getParticipationId(), $employeeId, $eventId,
                    $booking->getParticipationFee(), $eventDate, $booking->getVersion()], true);
        }
    }

    public function fetchFilteredResults(Filter $filters): array
    {
        $query = Queries::filter();

        $employeeName = '%' . $filters->getEmployeeName() . '%';
        $eventName = '%' . $filters->getEventName() . '%';
        $eventDate = '%' . $filters->getEventDate() . '%';

        $bindParams = ["sss", $employeeName, $eventName, $eventDate];
        return $this->prepareAndFetchFilter($query, $bindParams);
    }

    private function convertToUtc(string $eventDate): string
    {
        // Convert event date from "Europe/Berlin" to UTC
        $dateTime = new \DateTime($eventDate, new \DateTimeZone('Europe/Berlin'));
        $dateTime->setTimezone(new \DateTimeZone('UTC'));

        return $dateTime->format('Y-m-d H:i:s');
    }

    // this method returns existing record otherwise it creates new one and returns last inserted id
    private function prepareAndFetch($query, $parameter_types, $params, $insert = false)
    {
        $mysqli = $this->connection->getMysqli();
        $stmt = $mysqli->prepare($query);

        if ($stmt === false) {
            // Handle error, throw an exception, log, etc.
        }

        // Bind parameters
        if ($parameter_types && $params) {
            $stmt->bind_param($parameter_types, ...$params);
        }

        // Execute
        $stmt->execute();

        if(!$insert) {
            $stmt->bind_result($result);
            // Fetch result
            $stmt->fetch();
        } else {
            $result = $stmt->insert_id;
        }

        // Close statement
        $stmt->close();
        return $result;
    }

    public function prepareAndFetchFilter($query, $bindParams): array
    {
        // Prepare the statement
        $result = array();
        $stmt = $this->connection->getMysqli()->prepare($query);

        if ($stmt === false) {
            // Handle error, throw an exception, log, etc.
        }

        // Bind parameters
        $stmt->bind_param(...$bindParams);

        // Execute the query
        $stmt->execute();

        // Get the result metadata
        $meta = $stmt->result_metadata();

        // Fetch the field information
        $fields = $meta->fetch_fields();

        // Bind variables to the result dynamically
        $bindParams = [];
        foreach ($fields as $field) {
            $fieldName = $field->name;
            $bindParams[] = &$result[$fieldName];
        }

        // Bind the variables to the result
        call_user_func_array([$stmt, 'bind_result'], $bindParams);

        // Fetch results
        $results = [];
        while ($stmt->fetch()) {
            $currentResult = [];
            foreach ($result as $key => $value) {
                $currentResult[$key] = $value;
            }
            // Append a copy of the result to the results array
            $results[] = $currentResult;
        }
        $stmt->close();

        return $results;
    }
}
