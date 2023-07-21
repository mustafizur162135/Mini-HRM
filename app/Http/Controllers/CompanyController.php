<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Mail\NewCompanyNotification;
use App\Models\Company;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Exception;


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
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="event.preventDefault(); deleteCompany(event)">
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

        try {
            // Validate the incoming request data
            $validatedData = $request->validated();

            // Create a new company instance
            $company = new Company();
            $company->name = $validatedData['name'];
            $company->email = $validatedData['email'];

            if($request->hasFile('logo')){
                $image = $request->file('logo');
                $filename = 'assets/logos/'.time().mt_rand(10,10000).'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->put($filename, File::get($image));
                $company->logo = $filename;
            }

            // Save the company
            $company->save();

            Mail::to($company->email)->send(new NewCompanyNotification($company));

            notify()->success("Successfully Create Company", "Success", "topRight");

            return redirect()->route('companies.index');
        } catch (ValidationException $e) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            notify()->error("Failed to create company", "Error", "topRight");
            return redirect()->back()->withInput();
        }
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
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();

            $company->name = $validatedData['name'];
            $company->email = $validatedData['email'];

            // Handle logo update if provided and valid
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                // Delete the previous logo if exists
                if ($company->logo) {
                    Storage::delete($company->logo);
                }

                $image = $request->file('logo');
                $filename = 'assets/logos/'.time().mt_rand(10,10000).'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->put($filename, File::get($image));
                $company->logo = $filename;
            }

            $company->save();
            notify()->success("Successfully Update Company", "Success", "topRight");
            return redirect()->route('companies.index');
        } catch (ValidationException $e) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            notify()->error("Failed to update company", "Error", "topRight");
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Company $company)
    {
        try {
            // Delete the company logo file if it exists
            if ($company->logo) {
                Storage::delete($company->logo);
            }

            // Delete the company from the database
            $company->delete();

            notify()->success("Successfully deleted company", "Success", "topRight");
            return redirect()->route('companies.index');
        } catch (Exception $e) {
            notify()->error("Failed to delete company", "Error", "topRight");
            return redirect()->back()->withErrors(["error" => "Failed to delete company"]);
        }
    }
}
