<?php

namespace App\Repositories\Contracts;

interface MetricsRepositoryContract
{
    public function getData();

    public function cacheAllData();

    public function fetchAndCacheData();

    public function fetchData();

    public function getCacheKey();
}