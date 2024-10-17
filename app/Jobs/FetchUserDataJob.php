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
use Illuminate\Support\Facades\Log;

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
            Log::channel('campaign')->info('Fetching user data for campaign: ' . $this->campaign->name);

            // Get the API URL based on the app_id from the campaign
            $campaignApi = $this->campaign->campaignApi;

            if ($campaignApi && !empty($campaignApi->api_url)) {
                // Construct the API URL
                $apiUrl = rtrim($campaignApi->api_url, '/') . '/api/user-count';

                try {
                    // Make an API call to the external app to fetch user count
                    $response = Http::get($apiUrl, [
                        'source' => $this->campaign->source,
                    ]);

                    if ($response->successful()) {
                        $userCount = $response->json('user_count');

                        // Check if userCount is null before proceeding
                        if (!is_null($userCount)) {
                            // Store user data
                            CampaignUserData::create([
                                'campaign_id' => $this->campaign->id,
                                'user_count' => $userCount,
                                'fetched_at' => now(),
                            ]);

                            Log::channel('campaign')->info('User count for campaign ' . $this->campaign->name . ': ' . $userCount);

                            // Check against the threshold
                            if ($userCount < $this->campaign->threshold) {
                                // Trigger an email notification
                                try {
                                    // Send email with CC to multiple recipients
                                    \Mail::to('muneebto1256@gmail.com') // Main recipient
                                        ->cc(['muneebto876781@gmail.com', 'hassan@technowiz.tech']) 
                                        ->send(new \App\Mail\ThresholdAlert($this->campaign, $userCount));
                                    
                                    Log::channel('campaign')->info('Email notification sent for campaign ' . $this->campaign->name);
                                } catch (\Exception $e) {
                                    Log::channel('campaign')->error('Failed to send email notification for campaign ' . $this->campaign->name . ': ' . $e->getMessage());
                                }

                                Log::channel('campaign')->warning('User count (' . $userCount . ') for campaign ' . $this->campaign->name . ' is less than the threshold (' . $this->campaign->threshold . ').');
                            } else {
                                Log::channel('campaign')->info('User count (' . $userCount . ') for campaign ' . $this->campaign->name . ' is greater than or equal to the threshold (' . $this->campaign->threshold . ').');
                            }
                        } else {
                            Log::channel('campaign')->error('User count is null for campaign ' . $this->campaign->name . '. Skipping user data storage.');
                        }
                    } else {
                        Log::channel('campaign')->error('Failed to fetch user data from API for campaign ' . $this->campaign->name . '. Response: ' . $response->body());
                    }
                } catch (\Exception $e) {
                    Log::channel('campaign')->error('Error while fetching user data for campaign ' . $this->campaign->name . ': ' . $e->getMessage());
                }
            } else {
                Log::channel('campaign')->warning('No API URL found for campaign ' . $this->campaign->name . '. Skipping campaign.');
            }
        } else {
            Log::channel('campaign')->warning('Campaign ' . $this->campaign->name . ' is not active. Skipping campaign.');
        }
    }
}
