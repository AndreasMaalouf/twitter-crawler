<?php

namespace App\Repositories;

use App\Models\TweetedInstrument;
use App\Repositories\Contracts\MetricsRepositoryContract;
use Illuminate\Support\Facades\Cache;

class InstrumentRepository extends MetricsRepositoryContract
{
    private const KEY = 'instruments';

    public function fetchData()
    {
        $data = TweetedInstrument::query()->select('instrument')->groupBy('instrument')
            ->get()->keyBy('instrument');

        return $data;
    }

    public function getCacheKey(): string
    {
        return self::KEY;
    }
}