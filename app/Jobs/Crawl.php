<?php

namespace App\Jobs;

use App\Services\Crawler\CrawlerClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Crawl implements ShouldQueue
{
    use Dispatchable, SerializesModels, InteractsWithQueue;

    /**
     * Create a new job instance.
     */
    public function __construct(private CrawlerClient $client)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       $this->client->crawl();
    }
}
