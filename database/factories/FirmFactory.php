<?php

namespace Database\Factories;

use App\Models\Firm;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FirmFactory extends Factory
{
    protected $model = Firm::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(['Topstep', 'Apex', 'My Funded Futures']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
