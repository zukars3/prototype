<?php

namespace App\Services;

class Validator implements ValidatorInterface
{
    private DatabaseInterface $database;

    public function __construct()
    {
        $this->database = (new Database());
    }

    public function email(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    public function sum(string $sum): bool
    {
        $sum = floatval($sum);

        if (!$sum >= 1 && !$sum <= 1000000) {
            return false;
        }

        return true;
    }

    public function id(string $id): bool
    {
        if ($this->database->offer($id) == false) {
            return false;
        }

        return true;
    }
}