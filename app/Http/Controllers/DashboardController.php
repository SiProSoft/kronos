<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeEntry;
use App\Company;

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
        $company = $user->company;

        return view('dashboard')->with([
            'company' => $company
        ]);
    }

    public function storeCompany(Request $request) {
        $this->validate($request, [
            'title' => 'required',
        ]);
        
        $company = new Company;
        $company->title = $request->input('title');
        $company->user_id = auth()->user()->id;
        $company->save();

        $user = auth()->user();
        $user->companies()->attach($company->id);
        
        return redirect(route('dashboard'));
    }
}
