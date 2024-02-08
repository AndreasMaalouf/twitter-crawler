<?php

namespace App\Repositories;

use App\Models\TweetedInstrument;
use App\Repositories\Contracts\MetricsRepositoryContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MetricsRepository implements MetricsRepositoryContract
{
    private const KEY = 'top_instruments_days_';

    private $daysSince = 7;

    public function setDaysSince(int $daysSince): static
    {
        $this->daysSince = $daysSince;

        return $this;
    }

    public function getData()
    {
        $data = Cache::get(self::KEY.$this->daysSince);

        if ($data) {
            return $data;
        }

        return $this->fetchAndCacheData();
    }

    public function cacheAllData(): void
    {
        $this->fetchAndCacheData();
    }

    public function fetchAndCacheData()
    {
        $data = $this->fetchData();

        Cache::put(self::KEY.$this->daysSince, $data, now()->addMinutes(30));

        return $data;
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