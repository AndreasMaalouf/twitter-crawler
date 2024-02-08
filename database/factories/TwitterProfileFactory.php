<?php

namespace Database\Factories;

use App\Enums\TwitterProfile\Priorities;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TwitterFactory>
 */
class TwitterProfileFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'priority' => Priorities::Low->value,
            'should_scrape' => 1,
        ];
    }
}
