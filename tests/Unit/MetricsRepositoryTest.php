<?php

namespace Tests\Unit;

use App\Models\TweetedInstrument;
use App\Repositories\MetricsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class MetricsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_metrics_are_fetched_correctly()
    {
        TweetedInstrument::factory(5)->create();
        TweetedInstrument::factory(10)->create(['instrument' => '$ETH']);

        $repository = new MetricsRepository;
        $data = $repository->getData();
        $topInstrument = $data->first()->toArray()['instrument'];

        $this->assertEquals('$ETH', $topInstrument);

        $cachedData = Cache::get($repository->getCacheKey());
    
        $this->assertEquals($data, $cachedData);
    }
}