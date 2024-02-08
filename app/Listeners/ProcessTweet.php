<?php

namespace App\Listeners;

use App\Events\TweetInserted;
use App\Models\Tweet;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;
use Illuminate\Queue\InteractsWithQueue;

class ProcessTweet implements ShouldQueueAfterCommit
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(TweetInserted $event): void
    {
        $tweet = $event->tweet;
        $this->extractFinancialInstruments($tweet);
    }

    private function extractFinancialInstruments(Tweet $tweet)
    {
        $data = explode("\n", $tweet->tweet_text);
        $data = implode(' ', $data);
        $data = explode(' ', $data);

        $financialInstruments = [];

        foreach ($data as $word) {
            if ($word == "" || $word == " ") {
                continue;
            }

            $letters = str_split($word);
            if ($letters[0]!== '$') {
                continue;
            }

            $matched = preg_match('/^(\$)\w+/', $word);
            if ($matched) {
                $cleaned = preg_replace('/[,.-?!*&^#@\(\)\[\]]/', '', $word);
                $financialInstruments[$cleaned]['instrument'] = $cleaned;
            }
        }

        $this->insertFinancialInstruments($tweet, $financialInstruments);
        $tweet->setAsProcessed();
    }

    private function insertFinancialInstruments(Tweet $tweet, $instruments)
    {
        $tweet->instruments()->createMany(array_values($instruments));
    }
}
