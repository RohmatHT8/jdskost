<?php

namespace App\Livewire\Auth;

use App\Mail\WelcomeMail;
use App\Models\Branch;
use App\Models\DownPayment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Room;
use App\Models\UserRoom;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
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
    public $status;
    public $branch_id;
    public $date_in;
    public $aggrement;

    public function save()
    {
        // Validasi data termasuk validasi gambar
        // dd($this->aggrement);
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'image_ktp' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'phone_number' => 'required|string|max:15',
            'emergency_phone' => 'required|string',
            'image_selfie' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'job' => 'required|string|max:100',
            'long_stay' => 'required|in:Kurang dari 3 Bulan,3 Bulan,6 Bulan,1 Tahun,Lebih dari 1 Tahun',
            'amount_dp' => 'required|integer',
            'image_dp' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'role' => 'required|in:admin,user',
            'room_id' => 'required|exists:rooms,id',
            'status' => 'required|string',
            'branch_id' => 'required|integer',
            'date_in' => 'required|string',
            'aggrement' => 'accepted'
        ]);
        try {
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
                'role' => $this->role,
                'aggrement' => $this->aggrement,
            ]);

            DownPayment::create([
                'user_id' => $user->id,
                'amount' => $this->amount_dp,
                'tf_image' => $dp,
            ]);

            UserRoom::create([
                'user_id' => $user->id,
                'room_id' => $this->room_id,
                'status' => $this->status,
                'date_in' => $this->date_in,
                'anual_payment' => (int) \Carbon\Carbon::parse($this->date_in)->format('d')
            ]);
            $data = [];
            $data['name'] = $user->name;
            $data['password'] = $password;
            $data['number_room'] = Room::where('id', $this->room_id)->pluck('number_room')->first();
            $data['date'] = $this->date_in;
            Mail::to($user->email)->send(new WelcomeMail($data));
            auth()->login($user);
            return redirect()->intended();
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function uploadImage(UploadedFile $image, $directory = 'uploads')
    {
        return $image->store($directory, 'public');
    }

    public function render()
    {
        $rooms = [];
        $branches = Branch::get()->all();
        if ($this->branch_id && $this->status === 'in') {
            $rooms = Room::leftJoin('user_rooms as ur', 'rooms.id', '=', 'ur.room_id')
                ->where(function ($query) {
                    $query->whereRaw('ur.created_at = (SELECT MAX(created_at) FROM user_rooms sub_ur WHERE sub_ur.user_id = ur.user_id)')
                        ->orWhereNull('ur.created_at');
                })
                ->where(function ($query) {
                    $query->Where(function ($subQuery) {
                        $subQuery->where('ur.status', '=', 'in')
                            ->where('ur.date_out', '<=', now());
                    })
                        ->orWhereNull('ur.status');
                })
                ->where('rooms.branch_id', $this->branch_id)
                ->select('rooms.*')
                ->get();
        } else if ($this->branch_id && $this->status === 'book') {
            $rooms = Room::where('branch_id', $this->branch_id)->get();
        }
        return view('livewire.auth.register', compact('rooms', 'branches'));
    }
}
