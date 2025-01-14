<?php

namespace App\Livewire\Users;

use App\Mail\NotificationMail;
use App\Models\DownPayment;
use App\Models\UserRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class OutRoom extends Component
{
    public $date;
    public $userRoom;

    public function mount()
    {
        $this->userRoom = UserRoom::where('user_id', Auth::user()->id)->where('status', 'in')->first();
    }

    public function save()
    {
        $this->validate([
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $dateIn = $this->userRoom->date_in;
                    if (strtotime($value) <= strtotime("+1 month", strtotime($dateIn))) {
                        $fail('The Date attribute must be at least one month after the date in.');
                    }
                },
            ],
        ]);
        try {
            DB::beginTransaction();
            UserRoom::create([
                'user_id' => $this->userRoom->user_id,
                'room_id' => $this->userRoom->room_id,
                'date_in' => $this->userRoom->date_in,
                'date_out' => $this->date,
                'anual_payment' => $this->userRoom->anual_payment,
                'status' => 'out',
            ]);
            $user = Auth::user();
            $amountDp = DownPayment::where('user_id', $user->id)->pluck('amount')->first();
            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'no_rek' => $user->no_rek,
                'date' => $this->date,
                'long_stay' => $user->long_stay,
                'amount_dp' => $amountDp,
                'date_in' => $this->userRoom->date_in
            ];
            // Kirim email dari user yang login ke email Anda
            Mail::to('jdskost@gmail.com')
                ->send(new NotificationMail($data));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function render()
    {

        $isUserOut = UserRoom::where('user_id', $this->userRoom->user_id)
            ->where('room_id', $this->userRoom->room_id)
            ->where('status', 'out')
            ->first() ? true : false;
        $norek = Auth::user()->no_rek;
        return view('livewire.users.out-room', ['isUserOut' => $isUserOut, 'norek' => $norek]);
    }
}
