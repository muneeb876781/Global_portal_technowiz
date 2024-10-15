<?php

namespace App\Http\Controllers\Api\Organizer\Campaigns;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CampaigMonitoringnController extends Controller
{
    public function index()
    {
        // Get all campaigns that are not deleted and eager load userData relationship
        $campaigns = Campaign::with('userData')->where('is_deleted', 0)->get();
    
        // Get the current time in H:i format
        date_default_timezone_set('Asia/Karachi'); // Set to your desired timezone
        $currentTime = now()->format('H:i'); // Get current time
    
        // Update the status for each campaign
        foreach ($campaigns as $campaign) {
            if ($currentTime >= $campaign->starts_at && $currentTime < $campaign->pause_at) {
                $campaign->status = 1; // Set status to 1 if within time range
            } else {
                $campaign->status = 0; // Set status to 0 otherwise
            }
    
            // Save the updated status
            $campaign->save();
        }
    
        return view('Organizer.Dashboard.Pages.CampaignMonitoring.campaignMonitoring', compact('campaigns'));
    }
    

    public function pause($id)
    {
        // Set timezone to Asia/Karachi
        date_default_timezone_set('Asia/Karachi');

        // Find the campaign by ID
        $campaign = Campaign::findOrFail($id);

        // Update pause time and status
        // $fiveMinutesAgo = now()->subMinutes(5)->format('h:i');

        $pauseTime = now()->subMinutes(1)->format('H:i'); // Get the current pause time
        $campaign->pause_at = $pauseTime;

        $campaign->save();

        return redirect()
            ->back()
            ->with('pause_success', "Campaign will paused after $pauseTime.");
    }

    // public function start(Request $request, $id)
    // {
    //     $request->validate([
    //         'start_time' => 'required|date_format:H:i',
    //         'pause_time' => 'required|date_format:H:i',
    //     ]);

    //     $campaign = Campaign::findOrFail($id);

    //     date_default_timezone_set('Asia/Karachi');

    //     $campaign->starts_at = $request->start_time;
    //     $campaign->pause_at = $request->pause_time;

    //     $campaign->save();

    //     return redirect()->back() ->with('start_success', "Campaign will start after $campaign->starts_at.");
    // }

    public function start(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'pause_time' => 'required|date_format:H:i',
        ]);

        $campaign = Campaign::findOrFail($id);

        // Set the default timezone
        date_default_timezone_set('Asia/Karachi');

        // Parse the start time and subtract 1 minute
        $startTime = Carbon::createFromFormat('H:i', $request->start_time)->subMinute(1);

        // Parse the pause time
        $pauseTime = Carbon::createFromFormat('H:i', $request->pause_time);

        // Update the campaign with the adjusted start and pause times
        $campaign->starts_at = $startTime->format('H:i'); // Save in the desired format
        $campaign->pause_at = $pauseTime->format('H:i');

        $campaign->save();

        return redirect()->back()->with('start_success', "Campaign will start after $campaign->starts_at.");
    }
}
