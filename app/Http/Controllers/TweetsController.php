<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use App\Models\TweetedInstrument;
use App\Repositories\MetricsRepository;
use Symfony\Component\HttpFoundation\Response;

class TweetsController extends Controller
{
    public function __construct(private MetricsRepository $metricsRepository)
    {
    }

    /**
     * Returns latest 15 tweets for a tag
     *
     * @apiResourceCollection App\Http\Resources\TweetResource
     *
     * @apiResourceModel App\Models\Tweet 
     */
    public function get(string $tag)
    {
        $instruments = TweetedInstrument::select('instrument')->groupBy('instrument')->get()->keyBy('instrument')->toArray();
        abort_if(! isset($instruments[$tag]), Response::HTTP_BAD_REQUEST, 'Tag Not Found');

        return TweetResource::collection(Tweet::with('twitterProfile')->whereHas('instruments', function ($query) use ($tag) {
            $query->where('instrument', $tag);
        })->orderByDesc('tweet_date')->limit(15)->get());
    }

    /**
     * Returns latest 15 tweets
     *
     * @apiResourceCollection App\Http\Resources\TweetResource
     *
     * @apiResourceModel App\Models\Tweet 
     */
    public function index()
    {
        return TweetResource::collection(Tweet::with('twitterProfile')->orderByDesc('tweet_date')->limit(15)->get());
    }
}