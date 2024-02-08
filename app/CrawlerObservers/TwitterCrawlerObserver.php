<?php

namespace App\CrawlerObservers;

use App\CrawlerExtractors\TwitterCrawlerExtractor;
use App\Events\TweetParsed;
use App\Models\FailedCrawledTweets;
use App\Models\TwitterProfile;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class TwitterCrawlerObserver extends CrawlObserver
{

    public function __construct(private TwitterProfile $twitterProfile)
    {   
    }

    /*
     * Called when the crawler will crawl the url.
     */
    public function willCrawl(UriInterface $url, ?string $linkText): void
    {
    }

    /*
     * Called when the crawler has crawled the given url successfully.
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {
        $twitterHandle = $this->twitterProfile->twitter_handle;

        if (strpos($url->getPath(), "{$twitterHandle}/status/") !== false && strpos($url->getPath(), 'analytics') === false) {
           (new TwitterCrawlerExtractor($this->twitterProfile))->extract($url, $response);
        }
    }

    /*
     * Called when the crawler had a problem crawling the given url.
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {
        Log::warning('Crawling failed for: ' . (string)$url . PHP_EOL);
        $path = $url->getPath();

        FailedCrawledTweets::create(['path' => $path]);
    }

    /*
     * Called when the crawl has ended.
     */
    public function finishedCrawling(): void
    {
    }
}