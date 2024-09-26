<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;


    protected $primary = 'id';

    protected $fillable = ['name', 'latitude', 'longitude', 'radius'];

    protected static function booted()
    {
        static::saving(function ($office) {
            unset($office->location); // Menghapus field location sebelum insert/update
        });
    }

}
