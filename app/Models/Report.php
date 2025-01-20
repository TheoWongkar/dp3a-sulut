<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'ticket_number',
        'violence_category',
        'chronology',
        'date',
        'scene',
        'evidence',
    ];

    public static function generateTicketNumber()
    {
        do {
            $ticket_number = 'TKT-' . rand(1000, 9999) . now()->format('dmy');
        } while (self::where('ticket_number', $ticket_number)->exists());

        return $ticket_number;
    }

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

    public function latestStatus()
    {
        return $this->hasOne(Status::class)->latestOfMany();
    }
}
