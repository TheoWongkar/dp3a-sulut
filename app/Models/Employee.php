<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'name',
        'gender',
        'position',
        'date_of_birth',
        'address',
        'phone',
        'avatar',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
