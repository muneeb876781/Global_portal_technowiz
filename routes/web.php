<?php

use App\Http\Controllers\Api\Organizer\Applications\ApplicationController;
use App\Http\Controllers\Api\Organizer\Campaigns\CampaigMonitoringnController;
use App\Http\Controllers\Api\Organizer\Campaigns\CampaignController;
use App\Http\Controllers\Api\Organizer\Dasboard\DashboardController;
use App\Http\Controllers\Api\Organizer\Login\LoginController;
use App\Http\Controllers\Api\Organizer\ApiUrls\ApiUrlsController;
use App\Http\Controllers\Api\Organizer\BlackListedNumbers\BlacklistController;



use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('home');
Route::post('/organizer/login', [LoginController::class, 'login'])->name('organizer.login');
Route::post('/organizer/logout', [LoginController::class, 'logout'])->name('organizer.logout');

// Protected routes
Route::middleware('organizer.auth')->group(function () {
    // dashboard routes----------------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('organizer.dashboard');

    // application routes--------------
    Route::get('/applications', [ApplicationController::class, 'index'])->name('organizer.applications');
    Route::post('/organizer/applications/store', [ApplicationController::class, 'store'])->name('organizer.applications.store');
    Route::delete('/application/{id}', [ApplicationController::class, 'destroy'])->name('organizer.application.destroy');
    Route::get('/application/{id}/edit', [ApplicationController::class, 'edit'])->name('organizer.application.edit');
    Route::post('/application/{id}', [ApplicationController::class, 'update'])->name('organizer.application.update');

    // campaign setup routes-----------
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('organizer.campaignsetup');
    Route::post('/organizer/campaign/store', [CampaignController::class, 'store'])->name('organizer.campaign.store');
    Route::delete('/campaign/{id}', [CampaignController::class, 'destroy'])->name('organizer.campaign.destroy');
    Route::get('/campaign/{id}/edit', [CampaignController::class, 'edit'])->name('organizer.campaign.edit');
    Route::post('/campaign/{id}', [CampaignController::class, 'update'])->name('organizer.campaign.update');
    Route::post('/campaigns/{id}/restore', [CampaignController::class, 'restore'])->name('organizer.campaign.restore');

    // campaign monitoring 
    Route::get('/monitor', [CampaigMonitoringnController::class, 'index'])->name('organizer.campaignmonituring');
    Route::patch('/monitor/{id}/pause', [CampaigMonitoringnController::class, 'pause'])->name('organizer.campaign.pause');
    Route::post('/monitor/{id}/start', [CampaigMonitoringnController::class, 'start'])->name('organizer.campaign.start');
    
    // api url page routes
    Route::get('/apiUrls', [ApiUrlsController::class, 'index'])->name('organizer.apiUrls');
    Route::post('/apiUrls/store', [ApiUrlsController::class, 'store'])->name('organizer.api.store');
    Route::get('/apiUrls/{id}/edit', [ApiUrlsController::class, 'edit'])->name('organizer.api.edit');
    Route::post('/apiUrls/{id}', [ApiUrlsController::class, 'update'])->name('organizer.api.update');
    Route::delete('/apiUrls/{id}', [ApiUrlsController::class, 'destroy'])->name('organizer.api.destroy');

    // Black list Numbers routes
    Route::get('/BlacklistNumbers', [BlacklistController::class, 'index'])->name('organizer.BlacklistNumbers');
    Route::post('/BlacklistNumbers/store', [BlacklistController::class, 'store'])->name('organizer.blacklist.store');
    Route::patch('/BlacklistNumbers/{id}/blockAgain', [BlacklistController::class, 'blockAgain'])->name('organizer.blacklist.blockAgain');
    Route::patch('/BlacklistNumbers/{phn_no}/unblock', [BlacklistController::class, 'unblock'])->name('organizer.blacklist.unblock');

});
