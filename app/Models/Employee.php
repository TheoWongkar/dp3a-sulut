<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'nip',
        'name',
        'gender',
        'position',
        'date_of_birth',
        'address',
        'phone',
        'picture',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function posts()
    {
        return $this->hasMany(User::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
