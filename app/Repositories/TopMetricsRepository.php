<?php

namespace App\Repositories;

use App\Models\TweetedInstrument;
use App\Repositories\Contracts\MetricsRepositoryContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TopMetricsRepository implements MetricsRepositoryContract
{
    private const TOP_KEY = 'top_instruments_of_all_time';
    private const INSTRUMENT_ALL_TIME = 'instrument_all_time_record_';

    private const COUNT_KEY = 'total';
    private const INSTRUMENT_KEY = 'instrument';


    public function getData(): Collection
    {
        $topInstruments = Cache::get(self::TOP_KEY);
        if ($topInstruments) {
            return $topInstruments;
        }

        return $this->fetchAndCacheData();
    }

    public function cacheAllData(): void
    {
        $instruments = $this->fetchAndCacheData();

        $this->cacheInstrumentsCount($instruments);
    }

    public function fetchAndCacheData(): Collection
    {
        $instruments = $this->fetchData();

        Cache::put(self::TOP_KEY, $instruments, now()->addMinutes(60));

        return $instruments;
    }

    public function fetchData(): Collection
    {
        $instruments = TweetedInstrument::groupBy(self::INSTRUMENT_KEY)
            ->select(self::INSTRUMENT_KEY, DB::raw('count(*) as '.self::COUNT_KEY))
            ->orderByDesc('total')
            ->limit(15)
            ->get();

        return $instruments;
    }

    private function cacheInstrumentsCount($instruments): void
    {
        foreach($instruments as $record) {
            $this->cacheInstrument($record);
        }
    }

    private function cacheInstrument($record): void
    {
        $record = $record->toArray();
        $instrument = $record[self::INSTRUMENT_KEY];
        $total = $record[self::COUNT_KEY];

        Cache::put($this->getInstrumentCacheKey($instrument), $total, now()->addMinutes(60));
    }

    public function getCacheKey()
    {
        return self::TOP_KEY;
    }

    public function getInstrumentCacheKey(string $instrument)
    {
        return self::INSTRUMENT_ALL_TIME.$instrument;
    }
}