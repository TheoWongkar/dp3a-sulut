<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'place_of_birth',
        'address',
        'phone',
        'avatar',
        'status',
    ];

    protected $casts = [
        'nik' => 'encrypted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
