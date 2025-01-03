<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'no',
        'tf_image',
        'status',
        'amount',
        'note',
        'date'
    ];

    protected $appends = ['anual_payment'];

    public function rooms()
    {
        return $this->hasMany(RoomPayment::class);
    }

    public function getAnualPaymentAttribute()
    {
        $dateIn = UserRoom::where('room_id', $this->roomPayments->pluck('room_id')->first())
            ->where('status', 'in')
            ->pluck('date_in')
            ->first();

        $anualDate = (int) \Carbon\Carbon::parse($dateIn)->format('d');
        if ($anualDate > 28) {
            return 28;
        }
        return $anualDate;
    }

    public function roomPayments()
    {
        return $this->hasMany(RoomPayment::class, 'payment_id');
    }
}
