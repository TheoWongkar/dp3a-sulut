<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Victim extends Model
{
    /** @use HasFactory<\Database\Factories\VictimFactory> */
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

    public function setNikAttribute($value)
    {
        $this->attributes['nik'] = $value ? base64_encode(Crypt::encryptString($value)) : null;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = base64_encode(Crypt::encryptString($value));
    }

    public function getNikAttribute($value)
    {
        return $value ? Crypt::decryptString(base64_decode($value)) : null;
    }

    public function getNameAttribute($value)
    {
        return Crypt::decryptString(base64_decode($value));
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
