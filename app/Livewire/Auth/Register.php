<?php

namespace App\Livewire\Auth;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Room;
use App\Models\UserRoom;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Register extends Component
{
    use WithFileUploads;
    public $name;
    public $email;
    public $password;
    public $image_ktp;
    public $phone_number;
    public $emergency_phone;
    public $image_selfie;
    public $job;
    public $long_stay;
    public $amount_dp;
    public $image_dp;
    public $role = 'user';
    public $room_id;

    public function save()
    {
        // Validasi data termasuk validasi gambar
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'image_ktp' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'phone_number' => 'required|string|max:15',
            'emergency_phone' => 'required|string',
            'image_selfie' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'job' => 'required|string|max:100',
            'long_stay' => 'required|in:3 Bulan,6 Bulan,1 Tahun,Lebih dari 1 Tahun',
            'amount_dp' => 'required|integer',
            'image_dp' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'role' => 'required|in:admin,user',
            'room_id' => 'required|exists:rooms,id'
        ]);

        // Mengupload gambar dan menyimpan path-nya
        $ktp = $this->uploadImage($this->image_ktp);
        $selfie = $this->uploadImage($this->image_selfie);
        $dp = $this->uploadImage($this->image_dp);

        // Generate password dari nama depan dan tanggal saat ini
        $firstName = preg_replace('/\s+/', '', explode(' ', $this->name)[0]);
        $password = ucfirst($firstName) . now()->format('d/m');
        // User1911
        // Membuat record pengguna baru
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($password),
            'image_ktp' => $ktp,
            'phone_number' => $this->phone_number,
            'emergency_phone' => $this->emergency_phone,
            'image_selfie' => $selfie,
            'job' => $this->job,
            'long_stay' => $this->long_stay,
            'amount_dp' => $this->amount_dp,
            'image_dp' => $dp,
            'role' => $this->role,
        ]);

        UserRoom::create([
            'user_id' => $user->id,
            'room_id' => $this->room_id,
            'status' => 'in',
        ]);

        auth()->login($user);
        return redirect()->intended();
    }

    public function uploadImage(UploadedFile $image, $directory = 'uploads')
    {
        return $image->store($directory, 'public');
    }

    public function render()
    {
        $rooms = Room::leftJoin('user_rooms as ur', 'rooms.id', '=', 'ur.room_id')
            ->where(function ($query) {
                $query->whereRaw('ur.created_at = (SELECT MAX(created_at) FROM user_rooms sub_ur WHERE sub_ur.user_id = ur.user_id)')
                    ->orWhereNull('ur.created_at');
            })
            ->where(function ($query) {
                $query->where('ur.status', '!=', 'in')
                    ->orWhereNull('ur.status');
            })
            ->select('rooms.*')
            ->get();
        return view('livewire.auth.register', ['rooms' => $rooms]);
    }
}
