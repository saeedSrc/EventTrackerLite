<?php

require_once __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/../config/config.php';

include  __DIR__ . '/../template/filter_form.php';


use App\App;
use App\Database\Connection;
use App\Database\EventRepository;
use App\Service\JsonFileReader;

$connection = new Connection($config); // Initialize with appropriate parameters
$jsonReader = new JsonFileReader();
$eventRepository = new EventRepository($connection);

$app = new App($jsonReader, $eventRepository);
$app->processJsonData(__DIR__ . '/../booking.json');

// Handle form submission

    $filters = [
        'employee_name' => $_POST['employee_name'] ?? '',
        'event_name' => $_POST['event_name'] ?? '',
        'event_date' => $_POST['event_date'] ?? '',
    ];

    $filteredResults = $app->getFilteredResults($filters);
    include  __DIR__ . '/../template/filtered_results.php';



