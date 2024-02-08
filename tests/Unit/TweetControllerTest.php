<?php

namespace Tests\Unit;

use App\Models\Tweet;
use App\Models\TweetedInstrument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TweetControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_tweets_are_fetched_correctly()
    {
        TweetedInstrument::factory(4)->create(['instrument' => '$USD']);

        $response = $this->get('/tweets/$USD');
        $response->assertOk();
        $response->assertJsonCount(4, 'data');
    }

    public function test_tweet_structure()
    {
        $instrument = TweetedInstrument::factory()->create(['instrument' => '$USD']);

        /** @var Tweet $tweet */
        $tweet = $instrument->tweet;

        $response = $this->get('/tweets/$USD');
        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'tweet_id' => $tweet->tweet_id,
                    'tweet_text' => $tweet->tweet_text,
                    'tweet_date' => $tweet->tweet_date->format('d/m/Y H:i'),
                    'twitter_handle' => $tweet->twitterProfile->twitter_handle,
                ]
            ]
        ]);
    }
}