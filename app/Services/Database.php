<?php

namespace App\Services;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Collection;

class Database implements DatabaseInterface
{
    private Capsule $capsule;

    public function __construct()
    {
        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver' => config()->get('driver'),
            'host' => config()->get('host'),
            'database' => config()->get('database'),
            'username' => config()->get('username'),
            'password' => config()->get('password'),
            'charset' => config()->get('charset'),
            'collation' => config()->get('collation'),
            'prefix' => config()->get('prefix')
        ]);
        $this->capsule->setAsGlobal();
    }

    public function getEmail(int $id): string
    {
        return Capsule::table('applications')
            ->where('id', $id)
            ->value('email');
    }

    public function getDeals(): Collection
    {
        return Capsule::table('deals')
            ->join('applications', 'deals.application_id', '=', 'applications.id')
            ->select('deals.*', 'applications.*')
            ->get();
    }

    public function offer(int $applicationId): bool
    {
        $exists = Capsule::table('deals')
            ->where('application_id', '=', $applicationId)
            ->first();

        if ($exists == null) {
            return false;
        } else {
            Capsule::table('deals')
                ->where('application_id', $applicationId)
                ->update(['type' => 'offer']);
            return true;
        }
    }

    public function submit(string $email, string $sum): ?int
    {
        $exists = Capsule::table('applications')
            ->where('email', '=', $email)
            ->first();

        if ($exists == null) {
            return Capsule::table('applications')
                ->insertGetId(['email' => $email, 'sum' => $sum]);
        } else {
            return null;
        }
    }

    public function assign(int $id, string $sum): void
    {
        $partnerId = Capsule::table('partners')
            ->where([
                ['min_sum', '<=', $sum],
                ['max_sum', '>=', $sum]
            ])
            ->value('id');

        Capsule::table('deals')
            ->insert([
                'application_id' => $id,
                'partner_id' => $partnerId,
                'type' => 'ask'
            ]);
    }
}