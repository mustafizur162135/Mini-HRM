<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;




class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Company::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('companies.edit', $row->id);
                    $deleteUrl = route('companies.destroy', $row->id);

                    $btn = '<a href="' . $editUrl . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= '
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="delete btn btn-danger btn-sm">Delete</button>
                        </form>
                    ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('companies.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCompanyRequest $request)
    {
        // Create a new company instance
        $company = new Company();
        $company->name = $request['name'];
        $company->email = $request['email'];

        // Handle logo upload if provided
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoPath = 'assets/logos/' . $logoFile->getClientOriginalName(); // Adjust the storage path and file name as needed
            $logoStore = $logoFile->storeAs('public/assets/logos', $logoFile->getClientOriginalName()); // Store the file with the original name
            $company->logo = $logoPath;
        }

        // Save the company
        $company->save();
        return redirect()->route('companies.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('companies.form', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->name = $request->input('name');
        $company->email = $request->input('email');

        // Handle logo update if provided
        if ($request->hasFile('logo')) {
            // Delete the previous logo if exists
            if ($company->logo) {
                Storage::delete($company->logo);
            }

            $logoFile = $request->file('logo');
            $extension = $logoFile->getClientOriginalExtension();
            $fileName = 'logo.' . $extension;
            $logoPath = 'assets/logos/' . $logoFile->getClientOriginalName(); // Adjust the storage path and file name as needed
            $logoStore = $logoFile->storeAs('public/assets/logos', $fileName);
            $company->logo = $logoPath;
        }


        $company->save();

        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
