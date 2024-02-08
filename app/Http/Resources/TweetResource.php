<?php

namespace App\Http\Resources;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Tweet
 */
class TweetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tweet_text' => $this->tweet_text,
            'tweet_id' => $this->tweet_id,
            'tweet_date' => $this->tweet_date->format('d/m/Y H:i'),
            'twitter_handle' => $this->twitterProfile->twitter_handle,
        ];
    }
}
