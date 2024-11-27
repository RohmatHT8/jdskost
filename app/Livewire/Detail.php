<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Detail extends Component
{
    public $param;
    public $room;

    public $payment;

    public $isHidden = 'hidden';

    public function mount($param = null)
    {
        $this->param = $param;
        $this->resetModalData();
    }
    public function resetModalData()
    {
        $this->payment = null;
    }

    public function getPaymentId()
    {
        $this->payment = Room::with(['latestPayment'])
            ->where('id', $this->room->id) // Tambahkan kondisi untuk room_id
            ->get()
            ->map(function ($room) {
                return [
                    'room_id' => $room->id,
                    'payment_id' => $room->latestPayment?->id,
                    'amount' => $room->latestPayment?->amount,
                    'tf_image' => $room->latestPayment?->tf_image,
                    'status' => $room->latestPayment?->status,
                    'no' => $room->latestPayment?->no,
                    'created_at' => $room->latestPayment?->created_at,
                ];
            });
    }

    public function showModal()
    {
        $this->getPaymentId(); // Panggil data pembayaran        
        $this->isHidden = '';
    }

    public function approve()
    {
        $payment = Payment::create([
            'no' => $this->payment[0]['no'],
            'amount' => $this->payment[0]['amount'],
            'tf_image' => $this->payment[0]['tf_image'],
            'status' => 'approve'
        ]);

        RoomPayment::create([
            'room_id' => $this->room->id,
            'payment_id' => $payment->id
        ]);

        $this->isHidden = 'hidden';
        $this->resetModalData();
        session()->flash('message', 'Pembayaran telah di-approve!');
    }

    public function reject()
    {
        $payment = Payment::create([
            'no' => $this->payment[0]['no'],
            'amount' => $this->payment[0]['amount'],
            'tf_image' => $this->payment[0]['tf_image'],
            'status' => 'rejected'
        ]);

        RoomPayment::create([
            'room_id' => $this->room->id,
            'payment_id' => $payment->id
        ]);

        $this->closeModal();
        session()->flash('message', 'Pembayaran telah ditolak!');
    }

    public function closeModal(){
        return $this->isHidden = 'hidden';
    }

    public function sendBill()
    {
        $payment = Payment::create([
            'no' => 'billing',
            'amount' => $this->room->price,
            'tf_image' => 'billing',
            'status' => 'billing_proccess'
        ]);

        RoomPayment::create([
            'room_id' => $this->room->id,
            'payment_id' => $payment->id
        ]);
        session()->flash('message', 'Bill sudah terkirim');
    }

    public function render()
    {
        $this->room = Room::with('branch', 'roomPayments')->where('id', $this->param)->get()->first();
        $paymentDetails = Payment::join('room_payments as rp', 'rp.payment_id', '=', 'payments.id')
            ->where('rp.room_id', $this->room->id)
            ->orderBy('payments.created_at', 'desc')
            ->limit(10)
            ->get();
        return view('livewire.detail', ['room' => $this->room, 'paymentDetails' => $paymentDetails]);
    }
}
