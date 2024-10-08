<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function facilities()
    {
        return $this->belongsToMany(Hotel::class, 'facility_hotels');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'facility_rooms');
    }

    public function name()
    {
        return $this->title;
    }
}
