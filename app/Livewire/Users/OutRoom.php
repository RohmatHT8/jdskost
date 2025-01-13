<?php

namespace App\Livewire\Users;

use App\Models\UserRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        return view('livewire.users.out-room', ['isUserOut' => $isUserOut]);
    }
}
