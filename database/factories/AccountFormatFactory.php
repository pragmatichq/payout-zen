<?php

namespace Database\Factories;

use App\Enums\AccountFormatTypeEnum;
use App\Models\AccountFormat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AccountFormatFactory extends Factory
{
    protected $model = AccountFormat::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['150K Combine', '100K Combine', '50K Combine']),
            'type' => $this->faker->randomElement(AccountFormatTypeEnum::cases())->value,
            'starting_balance' => $this->faker->randomElement([5000000, 10000000, 15000000]),
            'profit_goal' => $this->faker->randomElement([400000, 900000, 1200000]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
