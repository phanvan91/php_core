<?php
// File: DIContainer.php
namespace Core;


class DIContainer
{
    private $services = [];

    public function addService($name, $service)
    {
        $this->services[$name] = $service;
    }

    public function getService($name)
    {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }

        throw new Exception("Service '$name' not found in the container.");
    }
}