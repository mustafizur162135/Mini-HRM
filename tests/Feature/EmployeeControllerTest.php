<?php

namespace Tests\Feature;

use Database\Factories\CompanyFactory;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\adminLogin;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, adminLogin;

    public function test_employee_index_page_is_accessible()
    {
        $this->setAdmin();

        $response = $this->get(route('employees.index'));

        $response->assertStatus(200);
    }

    public function test_employee_create_page_is_accessible()
    {
        $this->setAdmin();

        $response = $this->get(route('employees.create'));

        $response->assertStatus(200);
    }

    public function test_employee_can_be_created()
    {
        $this->setAdmin();

        $company = Company::factory()->create();

        // Create an employee record for the test.
        $employee = Employee::factory()->create([
            'company_id' => $company->id,
        ]);

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'company_id' => $employee->company_id,
        ];

        $response = $this->post(route('employees.store'), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('employees.index'));

        // Modify the following assertion to check if the data exists in the database
        // using the 'employees' table instead of the 'users' table.
        $this->assertDatabaseHas('employees', $data);
    }
    public function test_employee_can_be_updated()
    {

        $this->setAdmin();
        // Create an employee record for testing.
        $employee = Employee::factory()->create();

        // Create a company record for the employee.
        $company = Company::factory()->create();

        // Data for updating the employee record.
        $updatedData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'company_id' => $company->id, // Set the company_id field in the request data
        ];

        // Send a PATCH request to the update route of the EmployeeController.
        $response = $this->patch(route('employees.update', ['employee' => $employee->id]), $updatedData);

        // Assert that the response is a redirect.
        $response->assertStatus(302);

        // Assert that the redirect points to the employees.index route.
        $response->assertRedirect(route('employees.index'));

       

        // Refresh the employee model instance from the database to get the updated data.
        $employee->refresh();

        // Assert that the employee record in the database has been updated with the new data.
        $this->assertEquals($updatedData['first_name'], $employee->first_name);
        $this->assertEquals($updatedData['last_name'], $employee->last_name);
        $this->assertEquals($updatedData['email'], $employee->email);
        $this->assertEquals($updatedData['phone'], $employee->phone);
        $this->assertEquals($updatedData['company_id'], $employee->company_id); // Check the company_id
    }
}
