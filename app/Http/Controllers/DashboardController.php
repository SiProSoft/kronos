<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeEntry;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $company = 'SiProSoft';
        
        return view('dashboard')->with([
            'company' => $company
        ]);
    }
}
