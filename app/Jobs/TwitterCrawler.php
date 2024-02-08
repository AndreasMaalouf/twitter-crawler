<?php

namespace App\Jobs;

use App\CrawlerObservers\TwitterCrawlerObserver;
use App\CrawlProfiles\TweetCrawlProfile;
use App\Models\TwitterProfile;
use App\Services\Crawler\CrawlerClient;
use App\Enums\TwitterProfile\Priorities;
use Illuminate\Console\Scheduling\Schedule;

class TwitterCrawler
{

    public function __construct(private ?Schedule $schedule = null)
    {
    }

    public function handle()
    {

        // Because Chromium on docker for arm64 isn't very well supported
        // I attempted a solution that creates a chromium container that is why you can see the
        // ->setRemoteInstance() in the client. But javascript would not work, so I could not load the page to crawl
        // because twitter blocks it.
        //
        // Therefore changing the db host allows us to run the crawling on the local machine while inserting
        // the data on the mysql server hosted in a container.
        config(['database.connections.mysql.host' => '0.0.0.0']);

        $twitterProfiles = TwitterProfile::query()->where('should_scrape', true)->all();

        foreach ($twitterProfiles as $twitterProfile)
        {
            // builds observer for that profile that only ingests tweets
            $observer = new TwitterCrawlerObserver($twitterProfile);

            // sets parameters for crawler so that it only crawls tweets
            // and the initial page
            $tweetCrawlProfile = new TweetCrawlProfile($twitterProfile);

            $url = $twitterProfile->getTwitterUrl();

            $client = new CrawlerClient($observer, $tweetCrawlProfile, $url);

            $crawlJob = new Crawl($client);

            if ($this->schedule) {
                $this->scheduleJob($crawlJob, $twitterProfile);
            } else {
                $crawlJob->handle();
            }
        }
    }

    private function scheduleJob(Crawl $crawlJob, TwitterProfile $twitterProfile)
    {
        $priority = $twitterProfile->priority;

        if ($priority == Priorities::High->value) {
            $this->schedule->job($crawlJob)->everyFifteenMinutes();
        } elseif ($priority == Priorities::Mid->value) {
            $this->schedule->job($crawlJob)->everyTwoHours();
        } elseif ($priority == Priorities::Low->value) {
            $this->schedule->job($crawlJob)->everySixHours();
        }
    }
}