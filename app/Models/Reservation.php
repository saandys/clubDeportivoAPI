<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'member_id',
        'court_id',
        'date',
        'start_time',
        'end_time',
    ];

    public $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
      ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
