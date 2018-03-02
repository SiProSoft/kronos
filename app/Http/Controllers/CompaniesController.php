<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\User;

use App\Scopes\HiddenScope;

class CompaniesController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access:company')->only('show', 'edit', 'update', 'destroy');
        $this->middleware('access:company:true')->only('default', 'addUser', 'removeUser');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::forUser()->visible()->get();
        $personal = Company::forUser()->hidden()->first();

        return view('companies.index')->with([
            'companies' => $companies,
            'personal' => $personal
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateCompany($request);
        
        $company = new Company;
        $company->user_id = auth()->user()->id;

        $this->updateCompany($request, $company);

        auth()->user()->companies()->attach($company->id);
        
        return redirect(route('companies.index'))->with('success', 'Company stored');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return redirect(route('companies.index'));
        }

        $users = User::all();

        // if (!$users) {
        //     return redirect(route('companies.index'));
        // }

        $currentUsers = $company->users;

        return view('companies.show')->with(['company' => $company, 'users' => $users, 'currentUsers' => $currentUsers]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);
        return view('companies.edit')->with('company', $company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateCompany($request);
        
        $company = Company::find($id);
        $this->updateCompany($request, $company);
        
        return redirect(route('companies.index'))->with('success', 'Company updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();

        ensureCompany();
        return redirect(route('companies.index'))->with('success', 'Company deleted');
    }

    /**
     * Make the specified company default.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function default($id) {
        $company = Company::withoutGlobalScope(HiddenScope::class)->find($id);

        $user = auth()->user();
        $user->company()->associate($company);
        $user->save();

        ensureCompany();
        
        return redirect(route('companies.index'))->with('success', 'Default company changed');
    }

    public function validateCompany($request) {
        $this->validate($request, [
            'title' => 'required',
        ]);
    }

    public function updateCompany(Request $request, $company) {
        $company->title = $request->input('title');
        $company->country = $request->input('country');
        $company->city = $request->input('city');
        $company->street = $request->input('street');
        $company->phone = $request->input('phone');
        $company->email = $request->input('email');
        // $company->user_id = $company->user_id ?? auth()->user()->id;
        $company->save();

        return $company;
    }
    
    public function addUser(Request $request, $id) {
        $company = Company::find($id);
        $user = User::find($request->input('user_id'));
        
        if(!$company->users->contains($user)) {
            $company->users()->attach($request->input('user_id'));
            $company->save();
        }

        return redirect(route('companies.show', $id));
    }

    public function removeUser(Request $request, $id) {
        $company = Company::find($id);
        $company->users()->detach($request->input('user_id'));
        $company->save();

        ensureCompany();
        
        return redirect(route('companies.show', $id));

    }
}
