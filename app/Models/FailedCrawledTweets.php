<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $path
 * @property bool $retried_successfully
 */
class FailedCrawledTweets extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'path',
        'retried_successfully',
    ];
}
