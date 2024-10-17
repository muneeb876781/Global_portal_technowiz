<?php

namespace App\Console;

use App\Jobs\FetchUserDataJob;  
use App\Models\Campaign;        
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Get all active campaigns
            $campaigns = Campaign::where('status', 1)->get();
            Log::channel('campaign')->info('Active campaigns count: ' . $campaigns->count()); // Log the count

            // Dispatch the FetchUserDataJob for each active campaign
            foreach ($campaigns as $campaign) {
                // Ensure that the source is set in your campaign model
                if ($campaign->source) {
                    FetchUserDataJob::dispatch($campaign);
                    Log::channel('campaign')->info('Dispatched job for campaign : ' . $campaign->name);
                } else {
                    Log::channel('campaign')->info('Campaign  ' . $campaign->name . ' does not have a source set.');
                }
            }
        })->everyMinute();
    }


    

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
