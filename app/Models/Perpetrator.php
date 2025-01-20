<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perpetrator extends Model
{
    /** @use HasFactory<\Database\Factories\PerpetratorFactory> */
    use HasFactory;

    protected $fillable = [
        'report_id',
        'name',
        'age',
        'gender',
        'description',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
