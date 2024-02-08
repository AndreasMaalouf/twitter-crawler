<?php

namespace App\Repositories;

use App\Models\TweetedInstrument;
use App\Repositories\Contracts\MetricsRepositoryContract;
use Illuminate\Support\Facades\Cache;

class InstrumentRepository implements MetricsRepositoryContract
{
    private const KEY = 'instruments';

    private $daysSince = 7;

    public function getData()
    {
        $data = Cache::get($this->getCacheKey());

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

        Cache::put($this->getCacheKey(), $data, now()->addMinutes(30));

        return $data;
    }

    public function fetchData()
    {
        $data = TweetedInstrument::query()->select('instrument')->groupBy('instrument')
            ->get()->keyBy('instrument');

        return $data;
    }

    public function getCacheKey(): string
    {
        return self::KEY.$this->daysSince;
    }
}