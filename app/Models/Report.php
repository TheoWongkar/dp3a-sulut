<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_number',
        'violence_category',
        'description',
        'date',
        'scene',
        'evidence',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function victim()
    {
        return $this->hasOne(Victim::class);
    }

    public function perpetrator()
    {
        return $this->hasOne(Perpetrator::class);
    }

    public function reporter()
    {
        return $this->hasOne(Reporter::class);
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
}
