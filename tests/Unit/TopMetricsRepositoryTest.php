<?php

namespace Tests\Unit;

use App\Models\TweetedInstrument;
use App\Repositories\TopMetricsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class TopMetricsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_top_metrics_are_fetched_correctly()
    {
        TweetedInstrument::factory(5)->create();
        TweetedInstrument::factory(10)->create(['instrument' => '$BTC']);

        $repository = new TopMetricsRepository;
        $data = $repository->getData();
        $topInstrument = $data->first()->toArray()['instrument'];

        $this->assertEquals('$BTC', $topInstrument);

        $cachedData = Cache::get($repository->getCacheKey());
    
        $this->assertEquals($data, $cachedData);
    }

    public function test_caching_data()
    {
        TweetedInstrument::factory(5)->create(['instrument' => '$ETH']);
        TweetedInstrument::factory(3)->create(['instrument' => '$BTC']);
        TweetedInstrument::factory(2)->create(['instrument' => '$USD']);
        TweetedInstrument::factory(7)->create(['instrument' => '$EUR']);

        $repository = new TopMetricsRepository;
        $repository->cacheAllData();

        $this->assertEquals(5, Cache::get($repository->getInstrumentCacheKey('$ETH')));
        $this->assertEquals(3, Cache::get($repository->getInstrumentCacheKey('$BTC')));
        $this->assertEquals(2, Cache::get($repository->getInstrumentCacheKey('$USD')));
        $this->assertEquals(7, Cache::get($repository->getInstrumentCacheKey('$EUR')));
    }
}