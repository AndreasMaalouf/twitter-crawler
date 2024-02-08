<?php

namespace App\Console\Commands;

use App\Jobs\TwitterCrawler;
use Illuminate\Console\Command;

class RunTwitterCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-twitter-crawler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new TwitterCrawler())->handle();
    }
}
