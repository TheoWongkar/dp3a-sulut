<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspect extends Model
{
    /** @use HasFactory<\Database\Factories\SuspectFactory> */
    use HasFactory;

    protected $fillable = [
        'report_id',
        'nik',
        'name',
        'phone',
        'address',
        'age',
        'gender',
        'description',
    ];

    protected $casts = [
        'nik' => 'encrypted',
        'address' => 'encrypted',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
