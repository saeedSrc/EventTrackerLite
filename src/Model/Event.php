<?php

namespace App\Model;

class Event
{
    private $id; // You may want to include an ID property if events have unique IDs
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    // Implement getters and other methods as needed

    public function getName()
    {
        return $this->name;
    }
}
