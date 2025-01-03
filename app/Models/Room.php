<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'number_room',
        'image_room',
        'branch_id',
        'price'
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'room_payments');
    }

    public function status()
    {
        $available = Room::selectRaw('
                CASE 
                    WHEN user_rooms.room_id IS NULL THEN "available"
                    WHEN NOT MAX(user_rooms.status) = "in" THEN "available"
                    ELSE MAX(user_rooms.status)
                END AS status
            ')
            ->leftJoin('user_rooms', 'user_rooms.room_id', '=', 'rooms.id')
            ->groupBy('rooms.id', 'user_rooms.room_id')
            ->where('rooms.id', $this->id)
            ->first();

        if ($available->status === 'available') {
            return $available->status;
        }
        if ($this->hasNoPayments()) {
            return 'unpaid';
        }

        $payment = Payment::whereHas('roomPayments.room', function ($query) {
            $query->where('id', $this->id);
        })
            ->with(['roomPayments.room'])
            ->first();

        $appendsData = collect($payment->toArray())->only($payment->getAppends());
        // Log::info($appendsData['anual_payment']);
        $longPayment = RoomPayment::where('room_id', $this->id)
            ->latest('created_at')
            ->pluck('created_at')
            ->first();
        $isTimeForPay = $this->isWithinLast27DayAgo($longPayment);
        // $isTimeForPay = true;
        if ($appendsData['anual_payment'] <= $this->getTodayAsNumber() + 2 && $isTimeForPay) {
            return 'unpaid';
        }

        $status = Room::select('payments.status as payment_status')
            ->leftJoin('room_payments as rp', 'rp.room_id', '=', 'rooms.id')
            ->leftJoin('payments', 'payments.id', '=', 'rp.payment_id')
            ->where('rooms.id', $this->id)
            ->where(function ($query) {
                $query->where('payments.created_at', '=', function ($subquery) {
                    $subquery->selectRaw('MAX(p2.created_at)')
                        ->from('room_payments as rp2')
                        ->join('payments as p2', 'p2.id', '=', 'rp2.payment_id')
                        ->whereColumn('rp2.room_id', 'rooms.id');
                });
            })
            ->groupBy('rooms.id', 'payments.id', 'payments.status')
            ->first();
        return $status->payment_status;
    }
    public function isBook()
    {
        $book = DB::table('user_rooms')
            ->select(
                'user_id',
                'room_id',
                'status',
                'created_at',
                DB::raw("CASE WHEN status = 'book' THEN 'book' ELSE NULL END AS result_status")
            )
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('user_rooms')
                    ->where('room_id', $this->id)
                    ->groupBy('user_id');
            })
            ->pluck('result_status')
            ->first();
        return $book ? 'book' : null;
    }

    public function roomPayments()
    {
        return $this->hasMany(RoomPayment::class, 'room_id');
    }

    public function latestPayment()
    {
        return $this->hasOneThrough(Payment::class, RoomPayment::class, 'room_id', 'id', 'id', 'payment_id')
            ->latest('created_at');
    }

    function isWithinLast27DayAgo(string $date): bool
    {
        // Parse input date
        $inputDate = Carbon::parse($date);
        // Hitung selisih hari
        $daysDifference = Carbon::now()->diffInDays($inputDate);
        // Return true jika selisih hari >= 27
        return $daysDifference >= 27;
    }

    function getTodayAsNumber(): int
    {
        // Mengambil hari ini dan mengembalikannya dalam format angka
        return (int) Carbon::now()->format('d');
    }

    public function userRooms()
    {
        return $this->hasMany(UserRoom::class, 'room_id');
    }

    public function hasNoPayments(): bool
    {
        return $this->payments()->doesntExist();
    }
}
