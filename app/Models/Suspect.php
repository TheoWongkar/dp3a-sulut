<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function setNikAttribute($value)
    {
        $this->attributes['nik'] = $value ? base64_encode(Crypt::encryptString($value)) : null;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value ? base64_encode(Crypt::encryptString($value)) : null;
    }

    public function getNikAttribute($value)
    {
        return $value ? Crypt::decryptString(base64_decode($value)) : null;
    }

    public function getNameAttribute($value)
    {
        return $value ? Crypt::decryptString(base64_decode($value)) : null;
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
