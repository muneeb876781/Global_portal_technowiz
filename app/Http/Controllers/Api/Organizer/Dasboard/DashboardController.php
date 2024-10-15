<?php

namespace App\Http\Controllers\Api\Organizer\Dasboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('Organizer.Dashboard.Pages.index');
    }
    
}
