<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Facades\Cache;

abstract class MetricsRepositoryContract
{
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

    abstract function fetchData();

    abstract function getCacheKey();
}