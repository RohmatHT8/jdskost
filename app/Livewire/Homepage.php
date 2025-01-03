<?php

namespace App\Livewire;

use App\Models\Branch;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomPayment;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Homepage extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $room_id;
    public $amount;
    public $tf_image;
    public $note;
    public $search;
    public $selected_categories = [];
    public $selected_branch;

    protected $listeners = ['searchUpdated' => 'updateSearch', 'selectedCategoriesUpdated', 'selectedBranchUpdate'];

    public function updateSearch($searchTerm)
    {
        $this->search = $searchTerm;
    }
    public function selectedBranchUpdate($value)
    {
        $this->selected_branch = $value;
    }

    public function selectedCategoriesUpdated($value)
    {
        $this->selected_categories = $value;
    }

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
            'note' => $this->note,
            'status' => 'waiting_proccess'
        ]);

        RoomPayment::create([
            'room_id' => $this->room_id,
            'payment_id' => $payment->id,
            'user_id' => Auth::user()->id,
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
            $subquery = DB::table('user_rooms')
                ->select('*')
                ->whereIn('id', function ($query) {
                    $query->selectRaw('MAX(id)')
                        ->from('user_rooms')
                        ->groupBy('user_id');
                })
                ->whereNot('status', 'out');

            // Query utama menggunakan subquery
            $detail = DB::table('users as u')
                ->leftJoinSub($subquery, 'ur', 'ur.user_id', '=', 'u.id')
                ->leftJoin('rooms as r', 'r.id', '=', 'ur.room_id')
                ->where('u.id', Auth::user()->id)
                ->select('u.name', 'r.number_room', 'r.price', 'ur.status', 'ur.anual_payment')
                ->get();
            return view('livewire.homepage', compact('detail'));
        };
        if (Auth::user()->role === 'admin') {
            $rooms = Room::with('branch', 'roomPayments.room');
            if (!empty($this->search)) {
                $rooms->where('number_room', 'like', '%' . $this->search . '%');
            }
            if ($this->selected_branch) {
                $rooms->where('branch_id', $this->selected_branch);
            }
            return view('livewire.homepage', ['rooms' => $rooms->paginate(12)]);
        }
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
