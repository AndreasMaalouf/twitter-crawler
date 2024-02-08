<?php

namespace App\Repositories;

use App\Models\TweetedInstrument;
use App\Repositories\Contracts\MetricsRepositoryContract;
use Illuminate\Support\Facades\DB;

class MetricsRepository extends MetricsRepositoryContract
{
    private const KEY = 'top_instruments_days_';

    private $daysSince = 7;

    public function setDaysSince(int $daysSince): static
    {
        $this->daysSince = $daysSince;

        return $this;
    }

    public function fetchData()
    {
        $data = TweetedInstrument::query()->whereHas('tweet', function ($query) {
            $query->whereDate('tweet_date', '>', now()->subDays($this->daysSince));
        })->groupBy('instrument')
            ->select('instrument', DB::raw('count(*) as total'))
            ->orderByDesc('total')->limit(15)->get();

        return $data;
    }

    public function getCacheKey(): string
    {
        return self::KEY.$this->daysSince;
    }
}