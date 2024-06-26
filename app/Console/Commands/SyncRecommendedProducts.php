<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncRecommendedProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-top-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync top products from Alibaba API to local database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
