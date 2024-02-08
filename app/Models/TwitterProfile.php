<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $twitter_handle
 * @property string $priority
 * @property bool $should_scrape
 */
class TwitterProfile extends Model
{
    use HasFactory, HasUuids;

    private const TWITTER_URL = 'https://twitter.com/';

    protected $fillable = [
        'twitter_handle',
        'priority',
        'should_scrape',
    ];

    public function tweets(): HasMany
    {
        return $this->hasMany(Tweet::class, 'twitter_profile_id', 'id');
    }

    public function getTwitterUrl(): string
    {
        return self::TWITTER_URL.$this->twitter_handle;
    }
}
