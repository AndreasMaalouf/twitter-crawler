<?php

namespace App\Services\Crawler;

use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Spatie\Crawler\CrawlProfiles\CrawlProfile;

class CrawlerClient
{

    private $client;

    public function __construct(private CrawlObserver $observer, private CrawlProfile $crawlProfile, private string $url)
    {
        $browsershot = (new Browsershot)
            //->setRemoteInstance('172.22.0.100', '9222')
            ->windowSize(1920, 1080)
            ->waitUntilNetworkIdle()
            ->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36');

        $this->client = Crawler::create()->setCrawlObserver($this->observer)
            ->executeJavaScript()
            ->setBrowsershot($browsershot)
            ->setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36')
            ->setCrawlProfile($this->crawlProfile)
            ->ignoreRobots();
    }

    public function setLimit(int $limit): static
    {
        $this->client->setTotalCrawlLimit($limit);

        return $this;
    }

    public function crawl()
    {
        try {
            $this->client->startCrawling($this->url);
        } catch (\Exception $ex) {
            Log::warning($ex->getMessage());
        }
    }
}