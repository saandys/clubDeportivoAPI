<?php

namespace App\Models;

use App\Models\Sport;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Court extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'sport_id',
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
