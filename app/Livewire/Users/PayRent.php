<?php

namespace App\Livewire\Users;

use App\Models\Payment;
use App\Models\RoomPayment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

class PayRent extends Component
{
    use WithFileUploads;

    public $amount;
    public $tf_image;
    public $note;
    public $date;
    public $room_id;

    public function uploadImage(UploadedFile $image, $directory = 'uploads')
    {
        return $image->store($directory, 'public');
    }

    function generateInvoiceNumber()
    {
        $prefix = 'INV';
        $currentYear = date('Y');
        $currentDate = date('Ymd');

        $lastInvoice = DB::table('payments')
            ->where('no', 'LIKE', "{$prefix}-{$currentYear}%")
            ->orderBy('created_at', 'desc')
            ->value('no');

        if ($lastInvoice) {
            preg_match('/(\d+)$/', $lastInvoice, $matches);
            $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
        } else {
            $lastNumber = 0;
        }

        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        return "{$prefix}-{$currentDate}-{$nextNumber}";
    }

    public function savePayment()
    {
        session()->put('url.intended', 'detail-payment');

        $this->validate([
            'tf_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'amount' => 'required|integer',
            'date' => 'required',
        ]);

        $invoiceNumber = $this->generateInvoiceNumber();
        $image = $this->uploadImage($this->tf_image);
        // dd(['test' => $this->room_id]);
        $payment = Payment::create([
            'no' => $invoiceNumber,
            'amount' => $this->amount,
            'tf_image' => $image,
            'note' => $this->note,
            'date' => $this->date,
            'status' => 'waiting_proccess'
        ]);

        RoomPayment::create([
            'room_id' => $this->room_id->id,
            'payment_id' => $payment->id,
            'user_id' => Auth::user()->id,
        ]);

        session()->flash('message', 'Payment has been successfully saved!');

        $this->reset(['amount', 'tf_image']);

        return redirect()->intended();
    }

    public function render()
    {
        $this->room_id = User::join('user_rooms as ur', 'ur.user_id', '=', 'users.id')
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
        $statusPayment = Payment::join('room_payments as rp', 'rp.payment_id', '=', 'payments.id')
            ->where('rp.user_id', Auth::user()->id)
            ->where('rp.room_id', $this->room_id->id)
            ->pluck('status')
            ->first();
        return view('livewire.users.pay-rent', ['status' => $statusPayment]);
    }
}
