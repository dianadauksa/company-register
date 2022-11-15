<?php

namespace App;

class Company {
    private string $name;
    private string $registrationCode;

    public function __construct(string $name, string $registrationCode) {

        $this->name = $name;
        $this->registrationCode = $registrationCode;
    }

    public function __toString() {
        return "NOSAUKUMS: $this->name, REĢISTRĀCIJAS NUMURS: $this->registrationCode" . PHP_EOL;
    }
}