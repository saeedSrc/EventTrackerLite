<?php
namespace App\Controller;
use App\DTO\Filter;

class Controller
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function handleFormSubmission()
    {
        $filters = new Filter(
            htmlspecialchars($_POST['employee_name'] ?? ' '),
            htmlspecialchars($_POST['event_name'] ?? ' '),
            htmlspecialchars($_POST['event_date'] ?? ' ')
        );

        $filteredResults = $this->app->getFilteredResults($filters);

        include __DIR__ . '/../../template/filtered_results.php';

    }
}

