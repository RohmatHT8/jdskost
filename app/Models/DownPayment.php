<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'note',
        'amount',
        'tf_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
