<?php

namespace App\Events;

use App\Models\Tweet;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TweetInserted
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Tweet $tweet)
    {
    }
}
