<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomPayment;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Homepage extends Component
{
    use WithFileUploads;
    public $detail;
    public $room_id;
    public $room;
    public $payment;
    public $amount;
    public $tf_image;

    public function savePayment()
    {
        $this->validate([
            'tf_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'amount' => 'required|integer',
        ]);

        $invoiceNumber = $this->generateInvoiceNumber();
        $image = $this->uploadImage($this->tf_image);
        // dd(['test' => $this->room_id]);
        $payment = Payment::create([
            'no' => $invoiceNumber,
            'amount' => $this->amount,
            'tf_image' => $image,
            'status' => 'waiting_proccess'
        ]);

        RoomPayment::create([
            'room_id' => $this->room_id,
            'payment_id' => $payment->id
        ]);

        session()->flash('message', 'Payment has been successfully saved!');

        $this->reset(['amount', 'tf_image']);

        return redirect()->intended();
    }

    public function uploadImage(UploadedFile $image, $directory = 'uploads')
    {
        return $image->store($directory, 'public');
    }

    public function render()
    {
        if (Auth::user()->role === 'user') {
            $this->detail = User::join('user_rooms as ur', 'ur.user_id', '=', 'users.id')
                ->join('rooms as r', 'r.id', '=', 'ur.room_id')
                ->leftJoin('room_payments as rp', 'rp.room_id', '=', 'r.id')
                ->leftJoin('payments as p', 'p.id', '=', 'rp.payment_id')
                ->where('users.id', Auth::user()->id)
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.phone_number',
                    'users.emergency_phone',
                    'users.image_selfie',
                    'users.job',
                    'users.long_stay',
                    'users.amount_dp',
                    'ur.*',
                    'r.*',
                    DB::raw("
                    CASE 
                        WHEN p.id IS NULL THEN 'unpaid' 
                        ELSE (
                            SELECT p2.status 
                            FROM payments p2 
                            JOIN room_payments rp2 ON rp2.payment_id = p2.id
                            WHERE rp2.room_id = r.id
                            ORDER BY p2.created_at DESC
                            LIMIT 1
                        )
                    END AS status_payment
                ")
                )
                ->orderBy('ur.created_at', 'desc')
                ->limit(1)
                ->first();
            // dd(json_decode(json_encode($this->detail), true));
            $this->room_id = $this->detail->room_id;
            $this->payment = DB::table('room_payments as rp')
                ->join('payments as p', 'p.id', '=', 'rp.payment_id')
                ->where('rp.room_id', $this->detail->room_id)
                ->orderBy('p.created_at', 'desc') // Urutkan berdasarkan created_at (terbaru)
                ->select('rp.*', 'p.*')
                ->get();
            // dd(['payments' => json_decode(json_encode($this->payment), true)]);
        };
        if (Auth::user()->role === 'admin') {
            $this->room = Room::with('branch')->get()->all();
            // dd(['detail' => $this->room]);
        }
        return view('livewire.homepage', ['detail' => $this->detail, 'rooms' => $this->room, 'payments' => $this->payment]);
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
}
