<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    //---------------------------------------------------
    // Relationships
    //---------------------------------------------------

    public function families()
    {
        return $this->hasMany(Family::class);
    }
}
