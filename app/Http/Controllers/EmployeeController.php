<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::with('company')->select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('employees.edit', $row->id);
                    $deleteUrl = route('employees.destroy', $row->id);

                    $buttons = '<a href="' . $editUrl . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $buttons .= '<form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="deleteEmployee(event)">';
                    $buttons .= csrf_field();
                    $buttons .= method_field('DELETE');
                    $buttons .= '<button type="submit" class="delete btn btn-danger btn-sm">Delete</button>';
                    $buttons .= '</form>';

                    return $buttons;
                })
                ->editColumn('company.name', function ($row) {
                    return $row->company ? $row->company->name : '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('employees.index');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return view('employees.form', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmployeeRequest $request)
    {
        try {
            $employee = Employee::create($request->validated());
            // Additional logic if needed
            notify()->success('Employee created successfully.', 'Success');
            return redirect()->route('employees.index');
        } catch (\Exception $e) {
            $error = 'An error occurred while creating the employee.';
            notify()->error($error, 'Error');
            return redirect()->back();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $companies = Company::all(); // Fetch all companies to populate the company dropdown in the form
        return view('employees.form', compact('employee', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            $employee->update($request->validated());
            // Additional logic if needed
            notify()->success("Successfully updated employee", "Success", "topRight");
            return redirect()->route('employees.index');
        } catch (ValidationException $e) {
            notify()->error($e->getMessage(), "Error", "topRight");
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (QueryException $e) {
            notify()->error("Failed to update employee", "Error", "topRight");
            return redirect()->back()->withErrors(["error" => "Failed to update employee"]);
        } catch (Exception $e) {
            notify()->error("An error occurred", "Error", "topRight");
            return redirect()->back()->withErrors(["error" => "An error occurred"]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
            notify()->success("Successfully deleted employee", "Success", "topRight");
            return redirect()->route('employees.index');
        } catch (Exception $e) {
            notify()->error("Failed to delete employee", "Error", "topRight");
            return redirect()->back()->withErrors(["error" => "Failed to delete employee"]);
        }
    }
}
