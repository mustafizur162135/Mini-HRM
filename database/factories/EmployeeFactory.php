<?php
namespace Database\Factories;

use App\Models\Employee;
use App\Models\Company; // Import the Company model
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        // Get a random company_id from the existing companies in the database
        $company = Company::inRandomOrder()->first();

        // If there are no companies in the database, create a new one
        if (!$company) {
            $company = Company::factory()->create();
        }

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'company_id' => $company->id,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
