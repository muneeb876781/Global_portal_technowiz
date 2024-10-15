<?php

namespace App\Http\Controllers\Api\Organizer\Applications;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::all();

        return view('Organizer.Dashboard.Pages.Applications.applications', compact('applications'));
    }

    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'ApplicationName' => 'required|string|max:255',
            'ApplicationImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('ApplicationImage')) {
            $image2 = $request->file('ApplicationImage');
            $imageName2 = time() . '_2.' . $image2->getClientOriginalExtension();
            $media2Path = $image2->storeAs('public/uploads/Apps', $imageName2);
            $media2Path = $imageName2;
        } else {
            $media2Path = null;
        }

        // Create a new application entry
        Application::create([
            'name' => $request->ApplicationName,
            'image' => $media2Path,
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Application added successfully.');
    }

    public function destroy($id)
    {
        // Find the campaign by its ID
        $application = Application::findOrFail($id);

        // Delete the campaign
        $application->delete();

        // Redirect back with a success message
        return redirect()->back()->with('delete_success', 'Application deleted successfully.');
    }

    public function edit($id)
    {
        // Find the campaign by its ID
        $application = Application::findOrFail($id);

        // Pass the campaign and applications to the edit view
        return view('Organizer.Dashboard.Pages.Applications.edit', compact('application'));
    }

    public function update(Request $request, $id)
    {
        // Find the application by ID
        $application = Application::findOrFail($id);

        $request->validate([
            'ApplicationName' => 'required|string|max:255',
            'ApplicationImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('ApplicationImage')) {
            $image2 = $request->file('ApplicationImage');
            $imageName2 = time() . '_2.' . $image2->getClientOriginalExtension();
            $media2Path = $image2->storeAs('public/uploads/Apps', $imageName2);
            $media2Path = $imageName2;
        } else {
            $media2Path = null;
        }


        $application->name = $request->ApplicationName;
        $application->image = $media2Path;
        $application->save();

        // Redirect with success message
        return redirect()->route('organizer.applications')->with('update_success', 'Application updated successfully.');
    }


}
