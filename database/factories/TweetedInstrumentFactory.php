<?php

namespace Database\Factories;

use App\Enums\TwitterProfile\Priorities;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TweetedInstrument>
 */
class TweetedInstrumentFactory extends Factory
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
        $instruments = ['$BTC', '$ETH', '$GOLD', '$USD', '$EUR', '$AMD'];
        $randomKey = array_rand($instruments);

        return [
            'id' => Str::uuid(),
            'instrument' => $instruments[$randomKey],
            'tweet_id' => $tweet = (new TweetFactory)->create(),
        ];
    }
}
