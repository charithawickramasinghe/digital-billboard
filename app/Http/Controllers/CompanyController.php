<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies.
     */
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new company.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created company in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone_number' => 'required|string|max:20',
            'screen_count' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'renewal_date' => 'required|date|after:start_date',
            'email' => 'required|email|max:255',
            'status' => 'required|integer|in:0,1',
        ]);

        Company::create($validated);

        return redirect()->route('companies.index')->with('success', 'Company created successfully!');
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified company in storage.
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone_number' => 'required|string|max:20',
            'screen_count' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'renewal_date' => 'required|date|after:start_date',
            'email' => 'required|email|max:255',
            'status' => 'required|integer|in:0,1',
        ]);

        $company->update($validated);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully!');
    }

    /**
     * Remove the specified company from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully!');
    }
}
