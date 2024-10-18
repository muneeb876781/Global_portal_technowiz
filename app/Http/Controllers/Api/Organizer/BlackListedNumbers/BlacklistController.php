<?php

namespace App\Http\Controllers\Api\Organizer\BlackListedNumbers;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\BlacklistedNumbers;
use Illuminate\Http\Request;
use App\Models\CampaignAPI;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;



class BlacklistController extends Controller
{
    public function index()
    {
        // Fetch blacklisted numbers
        $blacklistedNumbers = BlacklistedNumbers::where('is_blocked', 1)->get(); 

        // Fetch unblocked numbers
        $unBlockedNumbers = BlacklistedNumbers::where('is_blocked', 0)->get(); 

        // Fetch all applications
        $applications = Application::all();

        // Return the view with the data
        return view('Organizer.Dashboard.Pages.BlacklistedNumbers.index', compact('blacklistedNumbers', 'applications', 'unBlockedNumbers'));
    }

    // previous stable
    // public function store(Request $request)
    // {
    //     // Log the start of the request
    //     Log::channel('blacklisting')->info('Received blacklist request', ['data' => $request->all()]);

    //     // Validate the form input
    //     $request->validate([
    //         'phone_number' => 'required|string|regex:/^92[0-9]{10}$/',
    //         'app_ids' => 'required|array',
    //         'app_ids.*' => 'integer',
    //         'reason' => 'nullable|string',
    //         'blacklisted_by' => 'required|string', // New validation for blacklisted_by
    //     ]);

    //     // Log validation success
    //     Log::channel('blacklisting')->info('Validation passed', [
    //         'phone_number' => $request->phone_number,
    //         'app_ids' => $request->app_ids,
    //         'blacklisted_by' => $request->blacklisted_by,
    //     ]);

    //     // Initialize a flag to check if the number is already blocked for any app
    //     $alreadyBlockedApps = []; // This will hold app IDs

    //     // Get the client's IP address
    //     $clientIp = $request->ip();

    //     foreach ($request->app_ids as $app_id) 
    //     {
    //         // Check if the phone number is already in the blacklist table
    //         $existingBlacklistedNumber = BlacklistedNumbers::where('phone_number', $request->phone_number)
    //             ->where('app_id', $app_id)
    //             ->first();

    //         // If number is already blocked for this app, add to the blocked apps list
    //         if ($existingBlacklistedNumber && $existingBlacklistedNumber->is_blocked == 1) {
    //             Log::channel('blacklisting')->warning('Phone number is already blacklisted for app', [
    //                 'phone_number' => $request->phone_number,
    //                 'app_id' => $app_id,
    //             ]);

    //             $alreadyBlockedApps[] = $app_id; // Add to already blocked apps array
    //             continue; // Skip to the next app
    //         }

    //         // If the number exists but is not blocked (is_blocked = 0), call the API and update the record
    //         if ($existingBlacklistedNumber && $existingBlacklistedNumber->is_blocked == 0) {
    //             // Call the API to block the number for this app
    //             $campaignApi = CampaignAPI::where('app_id', $app_id)->first();

    //             if (!$campaignApi) {
    //                 Log::channel('blacklisting')->error('App not found for app_id', ['app_id' => $app_id]);
    //                 continue; // Skip to the next app
    //             }

    //             // Prepare API URL and data
    //             $blacklistApiUrl = $campaignApi->api_url . '/api/blacklist';
    //             $apiData = [
    //                 'phone_number' => $request->phone_number,
    //             ];

    //             try {
    //                 // Log API call
    //                 Log::channel('blacklisting')->info('Calling external API to blacklist phone number', [
    //                     'api_url' => $blacklistApiUrl,
    //                     'api_data' => $apiData,
    //                 ]);

    //                 $response = Http::post($blacklistApiUrl, $apiData);

    //                 // Check if the API call was successful
    //                 if ($response->successful()) {
    //                     $responseData = $response->json();

    //                     if ($responseData['status'] === 'success') {
    //                         // Update the existing record to mark it as blocked
    //                         $existingBlacklistedNumber->update([
    //                             'is_blocked' => 1,
    //                             'blocked_at' => now(),
    //                             'reason' => $request->reason,
    //                             'blacklisted_by' => $request->blacklisted_by, // Store the username
    //                             'blacklisted_by_ip' => $clientIp, // Store the IP address
    //                         ]);

    //                         Log::channel('blacklisting')->info('Phone number successfully blacklisted and record updated', [
    //                             'phone_number' => $request->phone_number,
    //                             'app_id' => $app_id,
    //                         ]);                            
    //                     } else {
    //                         Log::channel('blacklisting')->error('Blacklist request failed in external API', ['response_data' => $responseData]);
    //                         return redirect()->back()->with('error', 'Blacklist request failed!');

    //                     }
    //                 } else {
    //                     Log::channel('blacklisting')->error('API call failed', [
    //                         'status' => $response->status(),
    //                         'error_message' => $response->body(),
    //                     ]);
    //                     return redirect()->back()->with('error', 'Blacklist request failed!');
    //                 }
    //             } catch (\Exception $e) {
    //                 Log::channel('blacklisting')->error('Exception occurred during API call', [
    //                     'error' => $e->getMessage(),
    //                     'trace' => $e->getTraceAsString(),
    //                 ]);
    //             }
    //         } else {
    //             // If the number is not present in the table, proceed with the regular blacklisting process
    //             $campaignApi = CampaignAPI::where('app_id', $app_id)->first();

    //             if (!$campaignApi) {
    //                 Log::channel('blacklisting')->error('App not found for app_id', ['app_id' => $app_id]);
    //                 continue; // Skip to the next app
    //             }

    //             // Prepare API URL and data
    //             $blacklistApiUrl = $campaignApi->api_url . '/api/blacklist';
    //             $apiData = [
    //                 'phone_number' => $request->phone_number,
    //             ];

    //             try {
    //                 // Log API call
    //                 Log::channel('blacklisting')->info('Calling external API to blacklist phone number', [
    //                     'api_url' => $blacklistApiUrl,
    //                     'api_data' => $apiData,
    //                 ]);

    //                 $response = Http::post($blacklistApiUrl, $apiData);

    //                 // Check if the API call was successful
    //                 if ($response->successful()) {
    //                     $responseData = $response->json();

    //                     if ($responseData['status'] === 'success') {
    //                         // Create a new blacklisted record in the database
    //                         BlacklistedNumbers::create([
    //                             'phone_number' => $request->phone_number,
    //                             'app_id' => $app_id,
    //                             'reason' => $request->reason,
    //                             'is_blocked' => 1,
    //                             'blocked_at' => now(),
    //                             'blacklisted_by' => $request->blacklisted_by, // Store the username
    //                             'blacklisted_by_ip' => $clientIp, // Store the IP address
    //                         ]);

    //                         Log::channel('blacklisting')->info('Phone number successfully blacklisted and stored in the database', [
    //                             'phone_number' => $request->phone_number,
    //                             'app_id' => $app_id,
    //                         ]);
    //                         return redirect()->back()->with('success', 'Phone number blacklisted successfully for the selected apps!');

    //                     } else {
    //                         Log::channel('blacklisting')->error('Blacklist request failed in external API', ['response_data' => $responseData]);
    //                         return redirect()->back()->with('error', 'Blacklist request failed!');
    //                     }
    //                 } else {
    //                     Log::channel('blacklisting')->error('API call failed', [
    //                         'status' => $response->status(),
    //                         'error_message' => $response->body(),
    //                     ]);
    //                     return redirect()->back()->with('error', 'Blacklist request failed!');
    //                 }
    //             } catch (\Exception $e) {
    //                 Log::channel('blacklisting')->error('Exception occurred during API call', [
    //                     'error' => $e->getMessage(),
    //                     'trace' => $e->getTraceAsString(),
    //                 ]);
    //             }
    //         }
    //     }

    //     // // After processing all apps, redirect with a success message
    //     return redirect()->back()->with('success', 'Phone number blacklisted successfully for the selected apps!');
    // }

    // new stable
    public function store(Request $request)
    {
        // Log the start of the request
        Log::channel('blacklisting')->info('Received blacklist request', ['data' => $request->all()]);

        // Validate the form input
        $request->validate([
            'phone_number' => 'required|string|regex:/^92[0-9]{10}$/',
            'app_ids' => 'required|array',
            'app_ids.*' => 'integer',
            'reason' => 'nullable|string',
            'blacklisted_by' => 'required|string',
        ]);

        // Log validation success
        Log::channel('blacklisting')->info('Validation passed', [
            'phone_number' => $request->phone_number,
            'app_ids' => $request->app_ids,
            'blacklisted_by' => $request->blacklisted_by,
        ]);

        $clientIp = $request->ip(); // Get the client's IP address
        $results = []; // To hold results for each app
        $client = new Client(); // Create a new Guzzle client

        foreach ($request->app_ids as $app_id) {
            $campaignApi = CampaignAPI::where('app_id', $app_id)->first();

            if (!$campaignApi) {
                Log::channel('blacklisting')->error('App not found for app_id', ['app_id' => $app_id]);
                $results[$app_id] = ['status' => 'error', 'message' => 'App not found'];
                continue; // Skip to the next app
            }

            $blacklistApiUrl = $campaignApi->api_url . '/api/blacklist';
            $apiData = [
                'phone_number' => $request->phone_number,
            ];

            try {
                // Call the external API
                Log::channel('blacklisting')->info('Calling external API to blacklist phone number', [
                    'api_url' => $blacklistApiUrl,
                    'api_data' => $apiData,
                ]);

                // Make the POST request using Guzzle
                $response = $client->post($blacklistApiUrl, [
                    'form_params' => $apiData, 
                ]);

                if ($response->getStatusCode() === 200) {
                    $responseData = json_decode($response->getBody(), true); // Decode JSON response

                    if ($responseData['status'] === 'success') {
                        // If successful, update local database
                        DB::table('blacklisted_numbers')->updateOrInsert(
                            ['phone_number' => $request->phone_number, 'app_id' => $app_id],
                            [
                                'phone_number' => $request->phone_number,
                                'app_id' => $app_id,
                                'reason' => $request->reason,
                                'is_blocked' => 1,
                                'blocked_at' => now(),
                                'blacklisted_by' => $request->blacklisted_by, // Store the username
                                'blacklisted_by_ip' => $clientIp, // Store the IP address
                                'updated_at' => now()
                            ]
                        );

                        $results[] = ['status' => 'success', 'message' => 'Phone number successfully blacklisted'];
                        Log::channel('blacklisting')->info('Phone number successfully blacklisted', ['app_id' => $app_id]);
                    } elseif ($responseData['status'] === 'alreadyblocked_success') {
                        // If already blacklisted, log it and update local DB
                        $results[] = ['status' => 'alreadyblocked_success', 'message' => 'Phone number already blacklisted'];
                        Log::channel('blacklisting')->warning('Phone number already blacklisted', ['app_id' => $app_id]);
                    } else {
                        // API failed for some reason
                        $results[] = ['status' => 'error', 'message' => 'Blacklist request failed'];
                        Log::channel('blacklisting')->error('API error', ['response_data' => $responseData]);
                    }
                } else {
                    // Handle HTTP failure
                    $results[] = ['status' => 'error', 'message' => 'Something went wrong'];
                    Log::channel('blacklisting')->error('API call failed', [
                        'status' => $response->getStatusCode(),
                        'error_message' => $response->getBody(),
                    ]);
                }
            } catch (RequestException $e) {
                // Handle exceptions during API call
                $results[] = ['status' => 'error', 'message' => 'Something went wrong'];
                Log::channel('blacklisting')->error('Exception during API call', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        // Redirect back with all results after processing all apps
        return redirect()->back()->with('results', $results);
    }

    //  previous stable
    // public function unblock(Request $request, $phone_number)
    // {
    //     $request->validate([
    //         'app_id' => 'required|integer',
    //     ]);

    //     $app_id = $request->app_id;


    //     // Log the start of the unblock request
    //     Log::channel('blacklisting')->info('Received unblock request', ['phone_number' => $phone_number]);

    //     // Check if the phone number exists in the BlacklistedNumbers table
    //     $existingBlacklistedNumber = BlacklistedNumbers::where('phone_number', $phone_number)
    //         ->where('app_id', $app_id)
    //         ->first();


    //     if (!$existingBlacklistedNumber) {
    //         Log::channel('blacklisting')->warning('Phone number not found in blacklist', ['phone_number' => $phone_number]);
    //         return redirect()->back()->withErrors(['Phone number not found in blacklist!']);
    //     }

    //     // Prepare the API URL for unblocking
    //     $campaignApi = CampaignAPI::where('app_id', $existingBlacklistedNumber->app_id)->first();

    //     // If app_id doesn't match any, return an error and log it
    //     if (!$campaignApi) {
    //         Log::channel('blacklisting')->error('App not found for app_id', ['app_id' => $existingBlacklistedNumber->app_id]);
    //         return redirect()->back()->withErrors(['App not found!']);
    //     }

    //     // Log API URL information
    //     Log::channel('blacklisting')->info('API URL found for app', ['api_url' => $campaignApi->api_url]);

    //     // Prepare the API URL for unblocking
    //     $unblockApiUrl = $campaignApi->api_url . '/api/unblock'; // Adjust this endpoint as necessary

    //     // Prepare the data for the API request
    //     $apiData = [
    //         'phone_number' => $phone_number,
    //     ];

    //     try {
    //         // Log the start of the API call
    //         Log::channel('blacklisting')->info('Calling external API to unblock phone number', ['api_url' => $unblockApiUrl, 'api_data' => $apiData]);

    //         // Make the API call to unblock the number in the other app
    //         $response = Http::patch($unblockApiUrl, $apiData);

    //         // Log the API response
    //         Log::channel('blacklisting')->info('API response received', ['status' => $response->status(), 'response' => $response->body()]);

    //         // Check if the response from the external API is successful
    //         if ($response->successful()) {
    //             $responseData = $response->json();

    //             // Log successful unblock response
    //             Log::channel('blacklisting')->info('Unblock request was successful', ['response_data' => $responseData]);

    //             // Update the blacklisted number in your own database
    //             $existingBlacklistedNumber->update([
    //                 'is_blocked' => 0, // Mark as unblocked
    //                 'unblocked_at' => now() // Add an unblocked timestamp
    //             ]);
                


    //             // Log successful update of blacklisted number
    //             Log::channel('blacklisting')->info('Phone number successfully unblocked in the database', ['blacklisted_number_id' => $existingBlacklistedNumber->id]);

    //             // Redirect or return with a success message
    //             return redirect()->back()->with('unlock_success', 'Phone number unblocked successfully!');
    //         } else {
    //             // Log failure in unblocking by external API
    //             Log::channel('blacklisting')->error('Unblock request failed in external API', ['response_data' => $responseData]);
    //             return redirect()->back()->withErrors(['Error unblocking number in the external app.']);
    //         }
    //     } catch (\Exception $e) {
    //         // Catch and log any errors with the API call
    //         Log::channel('blacklisting')->error('Exception occurred during API call', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    //         return redirect()->back()->withErrors(['API call failed: ' . $e->getMessage()]);
    //     }
    // }

    // new stable fun
    public function unblock(Request $request, $phone_number)
    {
        // Validate the request to ensure app_id is provided
        $request->validate([
            'app_id' => 'required|integer',
        ]);

        $app_id = $request->app_id;

        $existingBlacklistedNumber = BlacklistedNumbers::where('phone_number', $phone_number)
            ->where('app_id', $app_id)
            ->first();

        // Log the start of the unblock request
        Log::channel('blacklisting')->info('Received unblock request', ['phone_number' => $phone_number, 'app_id' => $app_id]);

        // Prepare the API URL for unblocking using the app_id
        $campaignApi = CampaignAPI::where('app_id', $app_id)->first();

        // If app_id doesn't match any, return an error and log it
        if (!$campaignApi) {
            Log::channel('blacklisting')->error('App not found for app_id', ['app_id' => $app_id]);
            return redirect()->back()->withErrors(['App not found!']);
        }

        // Log API URL information
        Log::channel('blacklisting')->info('API URL found for app', ['api_url' => $campaignApi->api_url]);

        // Prepare the API URL for unblocking
        $unblockApiUrl = $campaignApi->api_url . '/api/unblock'; // Adjust this endpoint as necessary

        // Prepare the data for the API request
        $apiData = [
            'phone_number' => $phone_number,
        ];

        try {
            // Create a Guzzle client
            $client = new Client();

            // Log the start of the API call
            Log::channel('blacklisting')->info('Calling external API to unblock phone number', ['api_url' => $unblockApiUrl, 'api_data' => $apiData]);

            // Make the API call to unblock the number in the other app
            $response = $client->patch($unblockApiUrl, [
                'json' => $apiData, // Send data as JSON
                'headers' => [
                    'Accept' => 'application/json', 
                ]
            ]);

            // Log the API response
            Log::channel('blacklisting')->info('API response received', ['status' => $response->getStatusCode(), 'response' => $response->getBody()->getContents()]);

            // Check if the response from the external API is successful
            if ($response->getStatusCode() === 200) {
                $responseData = json_decode($response->getBody(), true);

                // Log successful unblock response
                Log::channel('blacklisting')->info('Unblock request was successful', ['response_data' => $responseData]);

                $successMessage = $responseData['message'] ?? 'Phone number unblocked successfully!'; // Fallback message if 'message' is not found

                // Update the blacklisted number in your own database
                $existingBlacklistedNumber->update([
                    'is_blocked' => 0, // Mark as unblocked
                    'unblocked_at' => now() // Add an unblocked timestamp
                ]);

                // Log successful update of blacklisted number
                Log::channel('blacklisting')->info('Phone number successfully unblocked in the database', ['phone_number' => $phone_number]);

                // Redirect or return with a success message
                return redirect()->back()->with('unlock_success', $successMessage);
            } else {
                // Log failure in unblocking by external API
                Log::channel('blacklisting')->error('Unblock request failed in external API', ['response_data' => $response->getBody()->getContents()]);
                return redirect()->back()->with('unblock_error', 'Failed to Unblock the Number..');
            }
        } catch (RequestException $e) {
            // Catch and log any errors with the API call
            Log::channel('blacklisting')->error('Exception occurred during API call', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->withErrors(['API call failed: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            // Handle any other exceptions
            Log::channel('blacklisting')->error('Unexpected exception occurred', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->withErrors(['Unexpected error occurred: ' . $e->getMessage()]);
        }
    }


    


}
