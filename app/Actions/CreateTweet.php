<?php

namespace App\Actions;

use App\Models\TwitterProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CreateTweet
{
    public static function handle($tweetId, $tweetText, Carbon $tweetDate, TwitterProfile $profile): bool
    {
        $key = $profile->twitter_handle.'_tweets';
        $tweets = Cache::get($key);

        if (isset($tweets[$tweetId])) {
            return true;
        }

        try {
            $profile->tweets()->create([
                'tweet_id' => $tweetId,
                'tweet_text' => $tweetText,
                'tweet_date' => $tweetDate->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $ex) {
            Log::warning($ex->getMessage());
        }

        $tweets[$tweetId] = 1;
        Cache::set($key, $tweets, now()->addMinutes(30));

        return true;
    }
}
