<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckStock as JobsCheckStock;
use Illuminate\Support\Facades\Log;

class CheckStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for stock at 12:00 AM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
        // Log::info("Cron is working fine!");
        JobsCheckStock::dispatch();
        $this->info('stock checked successfully!');
    }
}
