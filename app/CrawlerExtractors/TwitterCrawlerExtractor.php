<?php

namespace App\CrawlerExtractors;

use App\Events\TweetParsed;
use App\Models\TwitterProfile;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class TwitterCrawlerExtractor
{
    public function __construct(private TwitterProfile $twitterProfile)
    {
    }

    public function extract(UriInterface $url, ResponseInterface $response)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($response->getBody());

        $this->extractFromDom($dom, $url->getPath());
    }

    public function extractFromDom(DOMDocument $dom, string $urlPath)
    {
        $xpath = new DOMXPath($dom);
        $tweets = $xpath->query('//div[@data-testid="tweetText"]');
        $time = $xpath->query('//time');
        $tweetDate = $time?->item(0)->attributes?->item(0)->textContent;

        if (! $tweetDate) {
            return;
        }

        // Extract Tweet Text
        $tweet = $tweets->item(0)->textContent;

        // Extract Tweet Id
        $tweetId = explode('/', $urlPath)[3];

        TweetParsed::dispatch($this->twitterProfile, $tweet, $tweetId, Carbon::parse($tweetDate));
    }
}