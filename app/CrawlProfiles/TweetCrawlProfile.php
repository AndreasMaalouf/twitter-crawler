<?php

namespace App\CrawlProfiles;

use App\Models\TwitterProfile;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlProfiles\CrawlProfile;

class TweetCrawlProfile extends CrawlProfile
{

    public function __construct(private TwitterProfile $twitterProfile)
    {   
    }

    public function shouldCrawl(UriInterface $url): bool
    {
        $tweetIds = $this->twitterProfile->tweets()->select('tweet_id')->get()->keyBy('tweet_id')->toArray() ?? [];

        $path = explode('/', $url->getPath());

        $alreadyCrawled = isset($path[3]) && isset($tweetIds[$path[3]]);
        $shouldNotCrawl = isset($path[4]) && in_array($path[4], [
            'analytics',
            'retweets',
            'likes',
            'photo',
        ]);

        return $path[1] == $this->twitterProfile->twitter_handle
            && (! isset($path[2]) || $path[2] == 'status')
            && ! $alreadyCrawled
            && ! $shouldNotCrawl;
    }
}