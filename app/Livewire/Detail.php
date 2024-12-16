<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomPayment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

use function Laravel\Prompts\select;

class Detail extends Component
{
    public $param;
    public $room;
    public $payment;
    public $userDetail;
    public $paymentDetail;
    public $isHidden = 'hidden';
    public $isHiddenDetail = 'hidden';
    public $userId;

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

    public function getPaymentIdDetail($id)
    {
        $this->paymentDetail = Payment::find($id);
        $this->isHiddenDetail = '';
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
            'payment_id' => $payment->id,
            'user_id' => $this->userId
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
            'payment_id' => $payment->id,
            'user_id' => $this->userId
        ]);

        $this->closeModal();
        session()->flash('message', 'Pembayaran telah ditolak!');
    }

    public function closeModal()
    {
        return $this->isHidden = 'hidden';
    }

    public function closeModalDetail()
    {
        return $this->isHiddenDetail = 'hidden';
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
            'payment_id' => $payment->id,
            'user_id' => $this->userId
        ]);
        session()->flash('message', 'Bill sudah terkirim');
    }

    public function render()
    {

        $this->room = Room::with('branch', 'roomPayments')->where('id', $this->param)->get()->first();
        $this->userId = DB::table('user_rooms')
            ->select(DB::raw("
                CASE 
                    WHEN status = 'out' THEN NULL
                    ELSE user_id
                END AS result
            "))
            ->where('room_id', $this->room->id)
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->value('user_id');
        $paymentDetails = DB::table('room_payments as rp')
            ->join('payments as p', 'p.id', '=', 'rp.payment_id')
            ->join('user_rooms as ur', 'ur.room_id', '=', 'rp.room_id')
            ->where('rp.room_id', $this->room->id)
            ->where('ur.user_id', $this->userId)
            ->orderBy('p.created_at', 'desc') // Urutkan berdasarkan created_at (terbaru)
            ->select('rp.*', 'p.*')
            ->get();
        $this->userDetail = User::find($this->userId);
        return view('livewire.detail', ['roomView' => $this->room, 'paymentDetails' => $paymentDetails, 'userDetailView' => $this->userDetail]);
    }
}
