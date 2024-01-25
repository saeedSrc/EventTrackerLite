<?php

namespace App\Database;

class Connection
{
    private $mysqli;

    public function __construct(array $config)

    {
        $db = $config['database'];
        $this->mysqli = new \mysqli($db['host'], $db['username'], $db['password'], $db['name'], $db['port']);

        // Check connection
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
    }

    public function getMysqli()
    {
        return $this->mysqli;
    }

}
