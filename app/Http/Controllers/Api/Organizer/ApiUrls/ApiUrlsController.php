<?php

namespace App\Http\Controllers\Api\Organizer\ApiUrls;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\CampaignAPI;
use Illuminate\Http\Request;

class ApiUrlsController extends Controller
{
    public function index()
    {
        $applications = Application::all();
        $apis = CampaignApi::all();

        return view('Organizer.Dashboard.Pages.ApiUrls.index', compact('applications', 'apis'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'app_id' => 'required|exists:applications,id', // Ensure the app_id exists in the applications table
            'api_url' => 'required|url', // Validate that the API URL is a valid URL
        ]);

        // Create a new CampaignApi entry in the database
        CampaignAPI::create([
            'app_id' => $validatedData['app_id'],
            'api_url' => $validatedData['api_url'],
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'API URL added successfully!');
    }

    public function destroy($id)
    {
        // Find the API URL by its ID or fail with a 404
        $apiUrl = CampaignAPI::findOrFail($id);

        // Delete the API URL from the database
        $apiUrl->delete();

        return redirect()->back()->with('delete_success', 'API URL deleted successfully!');
    }

    public function edit($id)
    {
        // Find the apiurl by its ID
        $apiurl = CampaignAPI::findOrFail($id);

        // Fetch related applications for dropdown
        $applications = Application::all();

        // Pass the campaign and applications to the edit view
        return view('Organizer.Dashboard.Pages.ApiUrls.edit', compact('apiurl', 'applications'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'app_id' => 'required|exists:applications,id',
            'api_url' => 'required|url',
        ]);

        // Find the existing campaign API by ID
        $campaignApi = CampaignAPI::findOrFail($id);

        // Update the campaign API with the new data
        $campaignApi->update([
            'app_id' => $request->app_id,
            'api_url' => $request->api_url,
        ]);

        // Redirect back with success message
        return redirect()->route('organizer.apiUrls')->with('update_success', 'API URL updated successfully!');
    }
}
