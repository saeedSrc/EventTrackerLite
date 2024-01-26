<?php
namespace App\Database;
class Queries
{
    public static function getEmployeeId()
    {
        return "SELECT employee_id FROM employees WHERE employee_mail = ?";
    }

    public static function createEmployee()
    {
        return "INSERT INTO employees (employee_name, employee_mail) VALUES (?, ?)";
    }

    public static function getEventId()
    {
        return "SELECT event_id FROM events WHERE event_name = ?";
    }

    public static function createEvent()
    {
        return "INSERT INTO events (event_name) VALUES (?)";
    }

    public static function getBookingId()
    {
        return "SELECT participation_id FROM bookings WHERE participation_id = ?";
    }

    public static function createdBooking() {
        return "INSERT INTO bookings (participation_id, employee_id, event_id, participation_fee, event_date, version)
                      VALUES (?, ?, ?, ?, ?, ?)";
    }
}


