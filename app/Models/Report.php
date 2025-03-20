<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $fillable = [
        'handled_id',
        'ticket_number',
        'violence_category',
        'chronology',
        'regency',
        'district',
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

    public function getRegencyNameAttribute()
    {
        static $regencyNames = null;

        if ($regencyNames === null) {
            $response = Http::get('https://ibnux.github.io/data-indonesia/kabupaten/71.json');
            $regencyNames = collect($response->json())->keyBy('id')->map->nama;
        }

        return $regencyNames[$this->regency] ?? 'Tidak Diketahui';
    }

    public function getDistrictNameAttribute()
    {
        static $districtNames = null;

        if ($districtNames === null) {
            $response = Http::get('https://ibnux.github.io/data-indonesia/kecamatan.json');
            $districts = collect($response->json());

            $districtNames = $districts->filter(fn($item) => str_starts_with($item['id'], '71'))
                ->keyBy('id')
                ->map->nama;
        }

        return $districtNames[$this->district] ?? 'Tidak Diketahui';
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_id');
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
