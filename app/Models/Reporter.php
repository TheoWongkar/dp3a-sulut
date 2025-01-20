<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporter extends Model
{
    /** @use HasFactory<\Database\Factories\ReporterFactory> */
    use HasFactory;

    protected $fillable = [
        'report_id',
        'name',
        'phone',
        'address',
        'relationship_between',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
