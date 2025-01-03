<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetailPayment extends Component
{
    public function render()
    {
        $detail = User::join('user_rooms as ur', 'ur.user_id', '=', 'users.id')
            ->join('rooms as r', 'r.id', '=', 'ur.room_id')
            ->leftJoin('room_payments as rp', 'rp.room_id', '=', 'r.id')
            ->leftJoin('payments as p', 'p.id', '=', 'rp.payment_id')
            ->where('users.id', Auth::user()->id)
            ->select(
                'r.id',
            )
            ->orderBy('ur.created_at', 'desc')
            ->limit(1)
            ->first();
        $payments = DB::table('room_payments as rp')
            ->join('payments as p', 'p.id', '=', 'rp.payment_id')
            ->where('rp.room_id', $detail->id)
            ->where('rp.user_id', Auth::user()->id)
            ->orderBy('p.created_at', 'desc') // Urutkan berdasarkan created_at (terbaru)
            ->select('rp.*', 'p.*');
        return view('livewire.users.detail-payment', ['payments' => $payments->paginate(10)]);
    }
}
