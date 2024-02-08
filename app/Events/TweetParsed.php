<?php

namespace App\Events;

use App\Models\TwitterProfile;
use Carbon\Carbon;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TweetParsed
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public TwitterProfile $twitterProfile, 
        public string $tweetText,
        public string $tweetId,
        public Carbon $tweetDate)
    {
    }
}
