<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;

trait AdminLogin
{
    use InteractsWithSession;

    public $admin;

    public function setAdmin()
    {
        // Create the admin user
        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        // Simulate admin login
        $response = $this->post('login', [
            'email' => $this->admin->email,
            'password' => 'password',
        ]);

        // Check if login was successful and the user is authenticated
        $this->assertAuthenticatedAs($this->admin);
    }
}
