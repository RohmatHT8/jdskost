<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Profile extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $showModal = false;
    public $showCurrentPassword = false;
    public $showNewPassword = false;

    protected $rules = [
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ];

    protected $messages = [
        'current_password.required' => 'Password saat ini wajib diisi.',
        'new_password.required' => 'Password baru wajib diisi.',
        'new_password.min' => 'Password baru harus minimal 8 karakter.',
        'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
    ];

    public function updatePassword()
    {
        $this->validate();

        $user = Auth::user();

        // Cek apakah password saat ini cocok
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password saat ini tidak cocok.');
            return;
        }

        // Update password baru
        $user->password = Hash::make($this->new_password);
        $user->save();

        // Flash message
        session()->flash('success', 'Password berhasil diubah.');

        // Reset input
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->showModal = false;
    }

    public function close()
    {
        return $this->showModal = false;
    }

    public function render()
    {
        $detail = User::with('downPayments')->find(Auth::user()->id);
        $detailArray = json_decode(json_encode($detail), true);
        $dp = $detailArray['down_payments'][0] ?? null;
        return view('livewire.users.profile', compact('detail', 'dp'));
    }
}
