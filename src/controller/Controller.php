<?php
namespace App\Controller;
class Controller
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function handleFormSubmission()
    {
        $employeeName = htmlspecialchars($_POST['employee_name'] ?? '');
        $eventName = htmlspecialchars($_POST['event_name'] ?? '');
        $eventDate = htmlspecialchars($_POST['event_date'] ?? '');

        $filters = [
            'employee_name' => $employeeName,
            'event_name' => $eventName,
            'event_date' => $eventDate,
        ];

        $filteredResults = $this->app->getFilteredResults($filters);

        include __DIR__ . '/../../template/filtered_results.php';

    }
}

