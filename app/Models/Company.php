<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'logo']; // Specify the fillable fields

    // Define relationships with other models if needed
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
