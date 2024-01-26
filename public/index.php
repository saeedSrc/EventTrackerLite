<?php

require_once __DIR__ . '/../vendor/autoload.php';
include  __DIR__ . '/../template/filter_form.php';
$config = require_once __DIR__ . '/../config/config.php';

use App\App;
use App\Database\Connection;
use App\Database\EventRepository;
use App\Service\JsonFileReader;
use App\Controller\Controller;

$connection = new Connection($config); // Initialize database connection
$jsonReader = new JsonFileReader();
$eventRepository = new EventRepository($connection);
$app = new App($jsonReader, $eventRepository);
$myController = new Controller($app);

// Handle json data
$myController->processJsonData(__DIR__ . '/../booking.json');

// Handle form submission
$myController->handleFormSubmission();



