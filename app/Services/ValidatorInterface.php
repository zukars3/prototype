<?php

namespace App\Services;

interface ValidatorInterface
{
    public function email(string $email): bool;

    public function sum(string $sum): bool;

    public function id(string $id): bool;
}