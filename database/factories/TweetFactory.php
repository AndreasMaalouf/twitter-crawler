<?php

namespace Database\Factories;

use App\Enums\TwitterProfile\Priorities;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Testing\Fakes\Fake;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tweet>
 */
class TweetFactory extends Factory
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
            'twitter_profile_id' => (new TwitterProfileFactory)->create(['twitter_handle' => Str::random(10)]),
            'tweet_text' => fake()->text('150'),
            'tweet_date' => now(),
            'tweet_id' => fake()->randomNumber()+fake()->randomNumber(),
        ];
    }
}
