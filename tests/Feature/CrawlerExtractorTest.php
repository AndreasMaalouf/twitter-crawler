<?php

namespace Tests\Feature;

use App\CrawlerExtractors\TwitterCrawlerExtractor;
use App\Models\TwitterProfile;
use DOMDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrawlerExtractorTest extends TestCase
{
    use RefreshDatabase;

    public function test_crawler_working_correctly()
    {
        $twitterHandle = 'charliebilello';
        $tweetId = '1439583504556335105';

        $twitterProfile = TwitterProfile::factory()->create([
            'twitter_handle' => $twitterHandle,
        ]);

        $url = '/'.$twitterProfile->twitter_handle.'/status/'.$tweetId;

        $dom = $this->getHTML();
        (new TwitterCrawlerExtractor($twitterProfile))->extractFromDom($dom, $url);

        $this->assertDatabaseCount('tweets', 1);
        $this->assertDatabaseCount('tweeted_instruments', 11);
    }

    private function getHTML()
    {
        $dom = (new DOMDocument);
        @$dom->loadHtml('<!DOCTYPE html>
        <html>
        <body>
            <div dir="auto" lang="en"
                    class="css-1rynq56 r-bcqeeo r-qvutc0 r-37j5jr r-1inkyih r-16dba41 r-bnwqim r-135wba7"
                    style="text-overflow: unset; color: rgb(15, 20, 25);" id="id__yuiktgcbsk"
                    data-testid="tweetText"><span class="css-1qaijid r-bcqeeo r-qvutc0 r-poiln3"
                        style="text-overflow: unset;">Total Returns over the last 10 Years...
                        Bitcoin </span> $BTC<span
                        class="css-1qaijid r-bcqeeo r-qvutc0 r-poiln3" style="text-overflow: unset;">: +994,608%
                        Tesla </span> $TSLA<span
                        class="css-1qaijid r-bcqeeo r-qvutc0 r-poiln3" style="text-overflow: unset;">: +15,200%
                        NVIDIA </span> $NVDA<span
                        class="css-1qaijid r-bcqeeo r-qvutc0 r-poiln3" style="text-overflow: unset;">: +6,053%
                        Netflix </span> $NFLX<span
                        class="css-1qaijid r-bcqeeo r-qvutc0 r-poiln3" style="text-overflow: unset;">: +2,337%
                        Amazon </span> $AMZN<span
                        class="css-1qaijid r-bcqeeo r-qvutc0 r-poiln3" style="text-overflow: unset;">: +1,427%
                        Microsoft </span> $MSFT<span
                        class="css-1qaijid r-bcqeeo r-qvutc0 r-poiln3" style="text-overflow: unset;">: +1,280%
                        Apple </span> $AAPL<span
                        class="css-1qaijid r-bcqeeo r-qvutc0 r-poiln3" style="text-overflow: unset;">: +1,112%
                        Google </span> $GOOGL<span
                        class="css-1qaijid r-bcqeeo r-qvutc0 r-poiln3" style="text-overflow: unset;">: +937%
                        S&amp;P 500 </span> $SPY<span
                        class="css-1qaijid r-bcqeeo r-qvutc0 r-poiln3" style="text-overflow: unset;">: +344%
                        Bonds </span> $AGG<span
                        class="css-1qaijid r-bcqeeo r-qvutc0 r-poiln3" style="text-overflow: unset;">: +35%
                        Gold </span> $GLD<span
                        class="css-1qaijid r-bcqeeo r-qvutc0 r-poiln3" style="text-overflow: unset;">: -6%
                        </span>
                        <time datetime="2021-09-19T13:33:48.000Z">3:33 pm · 19 Sep 2021</time>
                    </div>      
        </body>
        </html>');

        return $dom;
    }
}