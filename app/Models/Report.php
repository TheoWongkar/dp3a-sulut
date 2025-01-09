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

    public static function generateTicketNumber()
    {
        do {
            $ticketNumber = 'TKT-' . strtoupper(uniqid('', true)) . '-' . strtoupper(bin2hex(random_bytes(4))); // Example: TKT-605f4e16c4f2d4-7f3c19a1

        } while (self::where('ticket_number', $ticketNumber)->exists());

        return $ticketNumber;
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
}
