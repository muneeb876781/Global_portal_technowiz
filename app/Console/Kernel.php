<?php

namespace App\Console;

use App\Jobs\FetchUserDataJob;  // Import the job
use App\Models\Campaign;        // Import the Campaign model
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
            \Log::info('Active campaigns count: ' . $campaigns->count()); // Log the count

            // Dispatch the FetchUserDataJob for each active campaign
            foreach ($campaigns as $campaign) {
                // Ensure that the source is set in your campaign model
                if ($campaign->source) {
                    FetchUserDataJob::dispatch($campaign);
                    \Log::info('Dispatched job for campaign ID: ' . $campaign->id);
                } else {
                    \Log::warning('Campaign ID ' . $campaign->id . ' does not have a source set.');
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
