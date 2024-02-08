<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $instrument
 * @property string $tweet_id
 */
class TweetedInstrument extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tweet_id',
        'instrument',
    ];

    public function tweet(): BelongsTo
    {
        return $this->belongsTo(Tweet::class);
    }
}
