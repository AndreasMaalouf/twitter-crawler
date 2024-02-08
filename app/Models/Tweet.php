<?php

namespace App\Models;

use App\Events\TweetInserted;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $tweet_id
 * @property string $tweet_text
 * @property bool $processed
 */
class Tweet extends Model
{
    use HasFactory, HasUuids;

    protected $dispatchesEvents = [
        'created' => TweetInserted::class,
    ];

    protected $fillable = [
        'tweet_id',
        'tweet_text',
        'twitter_profile_id',
        'tweet_date',
    ];

    public function setAsProcessed(): void
    {
        $this->processed = true;
        $this->update();
    }

    public function instruments(): HasMany
    {
        return $this->hasMany(TweetedInstrument::class);
    }
}
