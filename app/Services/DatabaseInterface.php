<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface DatabaseInterface
{
    public function getEmail(int $id): string;

    public function getDeals(): Collection;

    public function offer(int $applicationId): bool;

    public function submit(string $email, string $sum): ?int;

    public function assign(int $id, string $sum): void;
}