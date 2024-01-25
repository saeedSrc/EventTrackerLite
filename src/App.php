<?php

namespace App;

use App\Database\Connection;
use App\Database\EventRepository;
use App\Service\JsonReaderInterface;

class App
{
    private $jsonReader;
    private $eventRepository;

    public function __construct(JsonReaderInterface $jsonReader, EventRepository $eventRepository)
    {
        $this->jsonReader = $jsonReader;
        $this->eventRepository = $eventRepository;
    }

    public function processJsonData(string $jsonFilePath)
    {
        $data = $this->jsonReader->readJsonData($jsonFilePath);

        // Insert data into the repository
        foreach ($data as $bookingData) {
            $employee = $this->initEmployee($bookingData);
            $event = $this->initEvent($bookingData);
            $booking = $this->initBooking($employee, $event, $bookingData);

            $this->eventRepository->insertBooking($booking);
        }
    }

    private function initEmployee(array $bookingData): Model\Employee
    {
        return new Model\Employee(
            $bookingData['employee_name'],
            $bookingData['employee_mail']
        );
    }

    private function initEvent(array $bookingData): Model\Event
    {
        return new Model\Event(
            $bookingData['event_name']
        );
    }

    private function initBooking(Model\Employee $employee, Model\Event $event, array $bookingData): Model\Booking
    {
        return new Model\Booking(
            $employee,
            $event,
            $bookingData['participation_fee'],
            $bookingData['participation_id'],
            $bookingData['event_date'],
            $bookingData['version']
        );
    }

    public function getFilteredResults(array $filters): array
    {
        $employeeName = $filters['employee_name'];
        $eventName = $filters['event_name'];
        $eventDate = $filters['event_date'];

        // Escape input to prevent SQL injection
        $employeeName = $this->eventRepository->escape($employeeName);
        $eventName = $this->eventRepository->escape($eventName);
        $eventDate = $this->eventRepository->escape($eventDate);

        // Build the SQL query based on the provided filters
        $query = "SELECT b.*, e.employee_name, ev.event_name
          FROM bookings b
          JOIN employees e ON b.employee_id = e.employee_id
          JOIN events ev ON b.event_id = ev.event_id
          WHERE 
          e.employee_name LIKE '%$employeeName%' AND 
          ev.event_name LIKE '%$eventName%' AND 
          b.event_date LIKE '%$eventDate%'";

        // Execute the query and return the results
        return $this->eventRepository->fetchFilteredResults($query);
    }

}
