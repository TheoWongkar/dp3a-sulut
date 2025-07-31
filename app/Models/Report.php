<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'violence_category',
        'chronology',
        'incident_date',
        'regency',
        'district',
        'scene',
        'evidence',
        'completed_at',
    ];

    public static function generateTicketNumber()
    {
        do {
            $ticket_number = 'TKT-' . rand(1000, 9999) . now()->format('dmY');
        } while (self::where('ticket_number', $ticket_number)->exists());

        return $ticket_number;
    }

    public function victim()
    {
        return $this->hasOne(Victim::class);
    }

    public function suspect()
    {
        return $this->hasOne(Suspect::class);
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
