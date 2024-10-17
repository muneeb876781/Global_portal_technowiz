<?php

namespace App\Http\Controllers\Api\Organizer\Campaigns;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 


class CampaignController extends Controller
{
    public function index()
    {
        $applications = Application::all();
        $campaigns = Campaign::where('is_deleted', 0)->get();
        $deletedCampaigns = Campaign::where('is_deleted', 1)->get();

        // Get the current time in H:i format
        date_default_timezone_set('Asia/Karachi'); // Set to your desired timezone
        $currentTime = now()->format('H:i'); // Get current time

        // Update the status for each campaign
        foreach ($campaigns as $campaign) {
            if ($currentTime >= $campaign->starts_at && $currentTime <= $campaign->pause_at) {
                $campaign->status = 1; // Set status to 1 if within time range
            } else {
                $campaign->status = 0; // Set status to 0 otherwise
            }

            // Save the updated status
            $campaign->save();
        }

        return view('Organizer.Dashboard.Pages.CampaignsSetup.Campaignsetup', compact('applications', 'campaigns', 'deletedCampaigns'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'campaignname' => 'required|string|max:255',
            'app_id' => 'required|exists:applications,id',
            'source' => 'required|string',
            'threshold' => 'required|integer', 
            'starts_at' => ['required', 'date_format:H:i'], 
            'pause_at' => ['required', 'date_format:H:i', 'after:starts_at'], 
        ]);

        // Store the campaign
        $campaign = new Campaign();
        $campaign->name = $request->campaignname;
        $campaign->app_id = $request->app_id;
        $campaign->source = $request->source;
        $campaign->threshold = $request->threshold; // Add threshold to campaign
        $campaign->starts_at = $request->starts_at;
        $campaign->pause_at = $request->pause_at;

        date_default_timezone_set('Asia/Karachi'); // Set to your desired timezone
        $currentTime = now()->format('H:i');

        // Compare the times correctly
        if ($currentTime >= $campaign->starts_at && $currentTime <= $campaign->pause_at) {
            $campaign->status = 1; // Set status to 1 if within time range
        } else {
            $campaign->status = 0; // Set status to 0 otherwise
        }

        $campaign->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Campaign added successfully.');
    }


    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);

        // Set is_deleted to 1 and update deleted_at with the current timestamp
        $campaign->is_deleted = 1;
        $campaign->deleted_at = now();
        $campaign->save();

        // Redirect back with a success message
        return redirect()->back()->with('delete_success', 'Campaign deleted successfully.');
    }

    public function restore($id)
    {
        // Find the campaign by its ID
        $campaign = Campaign::findOrFail($id);

        // Restore the campaign
        $campaign->is_deleted = 0; // Set is_deleted to 0
        $campaign->deleted_at = null; // Clear the deleted_at timestamp
        $campaign->save();

        // Redirect back with a success message
        return redirect()->back()->with('restore_success', 'Campaign restored successfully.');
    }

    public function edit($id)
    {
        // Find the campaign by its ID
        $campaign = Campaign::findOrFail($id);

        // Fetch related applications for dropdown
        $applications = Application::all();

        // Pass the campaign and applications to the edit view
        return view('Organizer.Dashboard.Pages.CampaignsSetup.edit', compact('campaign', 'applications'));
    }

    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        // Validate incoming data
        $request->validate([
            'campaignname' => 'required|string|max:255',
            'app_id' => 'required|exists:applications,id',
            'source' => 'required|string',
            'starts_at' => ['required', 'date_format:H:i'], // Time format validation
            'pause_at' => ['required', 'date_format:H:i', 'after:starts_at'], // Pause must be after start
        ]);

        // Store the campaign
        $campaign->name = $request->campaignname;
        $campaign->app_id = $request->app_id;
        $campaign->source = $request->source;
        $campaign->starts_at = $request->starts_at;
        $campaign->pause_at = $request->pause_at;

        // Determine the current time and set the status
        $currentTime = now()->format('H:i');
        if ($currentTime >= $campaign->starts_at && $currentTime <= $campaign->pause_at) {
            $campaign->status = 1; // Set status to 1 if within time range
        } else {
            $campaign->status = 0; // Set status to 0 otherwise
        }

        $campaign->save();

        // Redirect back with success message
        return redirect()->route('organizer.campaignsetup')->with('update_success', 'Campaign updated successfully.');
    }
}
