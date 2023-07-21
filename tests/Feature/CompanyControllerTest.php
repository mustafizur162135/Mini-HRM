<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test if the index page is accessible.
     */
    public function test_index_page_is_accessible()
    {
        $response = $this->get(route('companies.index'));

        // Check if the response is a redirect (status code 302)
        $response->assertStatus(302);

        // Follow the redirect and check if the redirected page is the correct one (status code 200)
        $response = $this->followRedirects($response);

        $response->assertStatus(200);
    }

    public function test_company_can_be_created()
    {
        $data = [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
        ];
        $this->setAdmin();

        $response = $this->post(route('companies.store'), $data);

        // Check if the company was created successfully and redirected to the index page
        $response->assertRedirect(route('companies.index'));

        // Check if the company data exists in the database
        $this->assertDatabaseHas('companies', $data);
    }

    public function test_company_can_be_updated()
    {
        $this->setAdmin();
        $company = Company::factory()->create();

        $data = [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
        ];

        $response = $this->patch(route('companies.update', $company->id), $data);

        // Check if the company was updated successfully and redirected to the index page
        $response->assertRedirect(route('companies.index'));

        // Check if the company data was updated in the database
        $this->assertDatabaseHas('companies', $data);
    }


}