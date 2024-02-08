<?php

namespace App\Http\Controllers;

use App\Http\Requests\TweetRequest;
use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use App\Models\TweetedInstrument;
use App\Repositories\MetricsRepository;
use Symfony\Component\HttpFoundation\Response;

class TweetsController extends Controller
{
    /**
     * Returns latest 15 tweets for a tag
     *
     * @apiResourceCollection App\Http\Resources\TweetResource
     *
     * @apiResourceModel App\Models\Tweet 
     */
    public function get(TweetRequest $request)
    {
        $tag = $request->route('tag');

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