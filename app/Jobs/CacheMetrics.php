<?php

namespace App\Jobs;

use App\Repositories\MetricsRepository;
use App\Repositories\TopMetricsRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CacheMetrics implements ShouldQueue
{
    use Dispatchable, SerializesModels, InteractsWithQueue;

    public function handle()
    {
        (new TopMetricsRepository)->cacheAllData();

        $ranges = [1, 7, 30, 120, 365];
        foreach ($ranges as $range) {
            (new MetricsRepository)->setDaysSince($range)->cacheAllData();
        }
    }
}