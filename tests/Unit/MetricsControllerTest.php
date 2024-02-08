<?php

namespace Tests\Unit;

use App\Models\TweetedInstrument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MetricsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_metrics_are_fetched_correctly()
    {
        TweetedInstrument::factory(3)->create();
        TweetedInstrument::factory(4)->create(['instrument' => '$USD']);

        $response = $this->get('/metrics/7');
        $response->assertOk();
        $content = $response->getContent();
        $data = collect(json_decode($content, true));

        $this->assertEquals('$USD', $data->first()['instrument']);
        $this->assertTrue($data->first()['total'] >= 4);
    }
}