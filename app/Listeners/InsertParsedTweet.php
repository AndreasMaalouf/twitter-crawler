<?php

namespace App\Listeners;

use App\Actions\CreateTweet;
use App\Events\TweetInserted;
use App\Events\TweetParsed;
use App\Models\Tweet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InsertParsedTweet implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(TweetParsed $event)
    {
        CreateTweet::handle($event->tweetId, $event->tweetText, $event->tweetDate, $event->twitterProfile);
    }
}