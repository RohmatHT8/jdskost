<?php

namespace App\Livewire;

use App\Mail\InvoiceMail;
use App\Mail\RejectMail;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomPayment;
use App\Models\User;
use App\Models\UserRoom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use clsTinyButStrong;
use Exception;
use Illuminate\Support\Facades\Mail;
use NcJoes\OfficeConverter\OfficeConverter;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpWord\TemplateProcessor;

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
    public $userSelect;
    public $userId;
    public $paymentDetails;
    public $note;
    public $name;

    public function mount($param = null)
    {
        $this->param = $param;
        $this->resetModalData();
        $this->room = Room::with('branch', 'roomPayments')->where('id', $this->param)->get()->first();
        $this->userSelect = User::select('id', 'name')->whereIn('id', UserRoom::where('room_id', $this->room->id)
            ->groupBy('user_id')
            ->pluck('user_id'))->get();
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
                    'date' => $room->latestPayment?->date,
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
        try {
            DB::beginTransaction();
            $name = User::where('id', $this->userId)->first();
            $payment = Payment::create([
                'no' => $this->payment[0]['no'],
                'amount' => $this->payment[0]['amount'],
                'tf_image' => $this->payment[0]['tf_image'],
                'date' => $this->payment[0]['date'],
                'status' => 'approve',
                'note' => $this->note
            ]);

            RoomPayment::create([
                'room_id' => $this->room->id,
                'payment_id' => $payment->id,
                'user_id' => $this->userId
            ]);

            // Data untuk mengisi template
            $data = [
                'name' => $name->name,
                'no' => $payment->no,
                'date' => formatDateIndo($payment->created_at),
                'recipient_name' => $name->name,
                'room' => $this->room->number_room,
                'description' => 'Sewa Kost ' . $this->room->id . ' ' . formatDateIndo($payment->date),
                'price' => formatRupiah($payment->amount),
                'total' => formatRupiah($payment->amount),
            ];

            // Path ke logo
            $imagePath = public_path('logo.png');
            if (!file_exists($imagePath)) {
                throw new \Exception("Logo tidak ditemukan di path: $imagePath");
            }

            // Encode gambar ke Base64
            $data['base64Logo'] = base64_encode(file_get_contents($imagePath));

            // Render Blade View sebagai HTML
            $htmlContent = view('templates.invoice', $data)->render();

            // Konfigurasi Dompdf
            $options = new Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $dompdf = new Dompdf($options);

            // Muat HTML ke Dompdf
            $dompdf->loadHtml($htmlContent);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Simpan PDF ke file
            $pdfOutputDir = public_path('print_pdfs');
            if (!is_dir($pdfOutputDir)) {
                mkdir($pdfOutputDir, 0755, true);
            }

            $pdfFilePath = $pdfOutputDir . '/' . uniqid('document_') . '.pdf';
            file_put_contents($pdfFilePath, $dompdf->output());

            // Kirim email dengan Mailtrap
            Mail::to($name->email)->send(new InvoiceMail($data, $pdfFilePath));

            // Kembalikan file PDF ke browser
            DB::commit();
            $this->closeModal();
            session()->flash('message', 'Pembayaran telah disetujui');
            return response()->download($pdfFilePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function reject()
    {
        try {
            DB::beginTransaction();
            $name = User::where('id', $this->userId)->first();
            
            $payment = Payment::create([
                'no' => $this->payment[0]['no'],
                'amount' => $this->payment[0]['amount'],
                'tf_image' => $this->payment[0]['tf_image'],
                'status' => 'rejected',
                'note' => $this->note,
                'date' => $this->payment[0]['date']
            ]);
    
            RoomPayment::create([
                'room_id' => $this->room->id,
                'payment_id' => $payment->id,
                'user_id' => $this->userId
            ]);

            $data=[];
            $data['name'] = $name->name;
            $data['note'] = $this->note;
            $data['date'] = $this->payment[0]['date'];
            Mail::to($name->email)->send(new RejectMail($data));    
            $this->closeModal();
            DB::commit();
            session()->flash('message-reject', 'Pembayaran telah ditolak!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
            'status' => 'billing_proccess',
            'note' => $this->note
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
        $roomStatus = [];
        if ($this->userId) {
            $this->userId = DB::table('user_rooms')
                ->select(DB::raw("
                   CASE 
                       WHEN NOT status = 'in' THEN user_id
                       ELSE user_id
                   END AS result
               "))
                ->where('room_id', $this->room->id)
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->value('user_id');
            $roomStatus = Room::join('user_rooms as ur', 'ur.room_id', '=', 'rooms.id')->where('rooms.id', $this->param)->where('ur.user_id', $this->userId)->select('rooms.*')->first();
        }
        $this->paymentDetails = DB::table('room_payments as rp')
            ->join('payments as p', 'p.id', '=', 'rp.payment_id')
            ->where('rp.room_id', $this->room->id)
            ->where('rp.user_id', $this->userId)
            ->orderBy('p.created_at', 'desc') // Urutkan berdasarkan created_at (terbaru)
            ->select('rp.*', 'p.*')
            ->get();

        $this->userDetail = User::join('user_rooms as ur', 'ur.user_id', '=', 'users.id')
            ->join('rooms as r', 'r.id', '=', 'ur.room_id')
            ->join('down_payments as dp', 'dp.user_id', '=', 'users.id')
            ->leftJoin('room_payments as rp', 'rp.room_id', '=', 'r.id')
            ->leftJoin('payments as p', 'p.id', '=', 'rp.payment_id')
            ->where('r.id', $this->room->id)
            ->where('users.id', $this->userId)
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.phone_number',
                'users.emergency_phone',
                'users.image_selfie',
                'users.job',
                'users.long_stay',
                'ur.*',
                'r.*',
                'dp.amount as amount_dp',
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

        return view('livewire.detail', ['roomView' => $this->room, 'paymentDetails' => $this->paymentDetails, 'userDetailView' => $this->userDetail, 'userSelect' => $this->userSelect, 'roomStatus' => $roomStatus]);
    }
}
