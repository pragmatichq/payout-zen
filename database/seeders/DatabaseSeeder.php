<?php

namespace Database\Seeders;

use App\Models\AccountFormat;
use App\Models\Firm;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Kyle Morck',
            'email' => 'kyle@payoutzen.com',
        ]);
        AccountFormat::factory()
            ->count(3)
            ->for(Firm::factory())
            ->create();
        AccountFormat::factory()
            ->count(3)
            ->for(Firm::factory())
            ->create();
    }
}
