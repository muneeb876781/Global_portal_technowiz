<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\CampaignUserData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchUserDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $campaign;

    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function handle()
    {
        // Check if the campaign is active (status 1)
        if ($this->campaign->status == 1) {
            \Log::info('Fetching user data for campaign ID: ' . $this->campaign->id);
            
            // Get the API URL based on the app_id from the campaign
            $campaignApi = $this->campaign->campaignApi; // Fetch the associated CampaignApi

            if ($campaignApi && !empty($campaignApi->api_url)) {
                // Construct the API URL
                $apiUrl = rtrim($campaignApi->api_url, '/') . '/api/user-count'; // Ensure no trailing slashes

                try {
                    // Make an API call to the external app to fetch user count based on status and source
                    $response = Http::get($apiUrl, [
                        'source' => $this->campaign->source, // Pass the campaign source to the API
                    ]);

                    if ($response->successful()) {
                        // Get the user count from the API response
                        $userCount = $response->json('user_count');

                        // Store the user data in the CampaignUserData table
                        CampaignUserData::create([
                            'campaign_id' => $this->campaign->id,
                            'user_count' => $userCount,
                            'fetched_at' => now(),
                        ]);

                        \Log::info('User count for campaign ID ' . $this->campaign->id . ': ' . $userCount);
                    } else {
                        \Log::error('Failed to fetch user data from API for campaign ID ' . $this->campaign->id);
                    }
                } catch (\Exception $e) {
                    \Log::error('Error occurred while fetching user data for campaign ID ' . $this->campaign->id . ': ' . $e->getMessage());
                }
            } else {
                // Log a warning if the API URL is not available for this campaign
                \Log::warning('No API URL found for campaign ID ' . $this->campaign->id . '. Skipping campaign.');
            }
        } else {
            \Log::warning('Campaign ID ' . $this->campaign->id . ' is not active. Skipping campaign.');
        }
    }





}
