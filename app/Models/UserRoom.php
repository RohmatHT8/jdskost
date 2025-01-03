<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class UserRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'room_id',
        'date_in',
        'date_out',
        'status',
        'anual_payment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
