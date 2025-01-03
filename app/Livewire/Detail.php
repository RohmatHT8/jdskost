<?php

namespace App\Livewire;

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

    // public function approve()
    // {
    //     $templatePath = storage_path('templates/Hello.odt');
    //     $data = [
    //         'name' => 'John Doe',
    //         'order_id' => '12345',
    //         'date' => date('Y-m-d'),
    //     ];

    //     include_once base_path('vendor/tinybutstrong/tinybutstrong/tbs_class.php');
    //     include_once base_path('vendor/tinybutstrong/opentbs/tbs_plugin_opentbs.php');

    //     // Inisialisasi TBS
    //     $TBS = new clsTinyButStrong;
    //     $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

    //     // Load template DOCX
    //     $TBS->LoadTemplate($templatePath, OPENTBS_ALREADY_UTF8);
    //     $TBS->MergeField('name', $data['name']);
    //     $TBS->MergeField('order_id', $data['order_id']);
    //     $TBS->MergeField('date', $data['date']);

    //     $tempFileName = md5(uniqid(rand(), true) . time());

    //     $tempFile = 'print_odt/' . $tempFileName . '.odt';
    //     $TBS->Show(OPENTBS_FILE, $tempFile);

    //     dd('masih nyam,pe');
    //     $outputtemplate = public_path($tempFile);
    //     $converter = new OfficeConverter(
    //         $outputtemplate,
    //         public_path('print_odt'),
    //         'soffice',
    //         (strtolower(PHP_OS_FAMILY) != 'windows')
    //     );
    //     $converter->convertTo($tempFileName . '.pdf');
    //     $pdfFile = public_path('print_odt/' . $tempFileName . '.pdf');
    //     dd('sampai sini');
    //     // Kirim email dengan PDF sebagai lampiran
    //     // Mail::send([], [], function ($message) use ($pdfPath, $data) {
    //     //     $message->to('rohmathidayattullah97@gmail.com')
    //     //         ->subject('Invoice #' . $data['order_id'])
    //     //         ->setBody('Hello ' . $data['name'] . ', your invoice is attached.')
    //     //         ->attach($pdfPath);
    //     // });

    //     // // Hapus file sementara
    //     // Storage::delete($docxFileName);
    //     // Storage::delete($pdfFileName);

    //     // session()->flash('message', 'File PDF berhasil dibuat dan dikirim melalui email.');

    //     // $payment = Payment::create([
    //     //     'no' => $this->payment[0]['no'],
    //     //     'amount' => $this->payment[0]['amount'],
    //     //     'tf_image' => $this->payment[0]['tf_image'],
    //     //     'status' => 'approve',
    //     //     'note' => $this->note
    //     // ]);

    //     // RoomPayment::create([
    //     //     'room_id' => $this->room->id,
    //     //     'payment_id' => $payment->id,
    //     //     'user_id' => $this->userId
    //     // ]);

    //     // $this->isHidden = 'hidden';
    //     // $this->resetModalData();
    //     // session()->flash('message', 'Pembayaran telah di-approve!');
    // }

    public function approve()
    {
        try {
            // Path template dan direktori output
            $templatePath = storage_path('templates/Hello.odt');
            $outputDir = public_path('print_odt');

            // Data untuk merge
            $data = [
                'name' => 'John Doe',
                'order_id' => '12345',
                'date' => date('Y-m-d'),
            ];

            // Include library TinyButStrong dan OpenTBS
            include_once base_path('vendor/tinybutstrong/tinybutstrong/tbs_class.php');
            include_once base_path('vendor/tinybutstrong/opentbs/tbs_plugin_opentbs.php');

            // Inisialisasi TBS
            $TBS = new clsTinyButStrong;
            $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

            // Load template ODT
            if (!file_exists($templatePath)) {
                throw new Exception("Template file tidak ditemukan: $templatePath");
            }

            $TBS->LoadTemplate($templatePath, OPENTBS_ALREADY_UTF8);
            $TBS->MergeField('name', $data['name']);
            $TBS->MergeField('order_id', $data['order_id']);
            $TBS->MergeField('date', $data['date']);

            // Generate file sementara ODT
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            $tempFileName = md5(uniqid(rand(), true) . time());
            $tempOdtFile = $outputDir . '/' . $tempFileName . '.odt';
            $TBS->Show(OPENTBS_FILE, $tempOdtFile);

            if (!file_exists($tempOdtFile)) {
                throw new Exception("Gagal membuat file ODT.");
            }

            // Konversi ODT ke PDF
            $tempPdfFile = $outputDir . '/' . $tempFileName . '.pdf';
            $libreOfficePath = 'soffice'; // Pastikan path LibreOffice sudah ditambahkan ke PATH

            $command = escapeshellcmd("$libreOfficePath --headless --convert-to pdf --outdir " . escapeshellarg($outputDir) . " " . escapeshellarg($tempOdtFile));
            $output = [];
            $returnCode = 0;

            exec($command, $output, $returnCode);

            if ($returnCode !== 0 || !file_exists($tempPdfFile)) {
                throw new Exception("Gagal mengonversi ODT ke PDF. Output: " . implode("\n", $output));
            }

            // Hapus file ODT jika tidak diperlukan lagi
            unlink($tempOdtFile);

            // Flash message sukses
            session()->flash('success', 'Dokumen berhasil dibuat dan dikonversi ke PDF.');

            return response()->download($tempPdfFile)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            // Flash message error
            session()->flash('error', $e->getMessage());

            return redirect()->back();
        }
    }

    public function reject()
    {
        $payment = Payment::create([
            'no' => $this->payment[0]['no'],
            'amount' => $this->payment[0]['amount'],
            'tf_image' => $this->payment[0]['tf_image'],
            'status' => 'rejected',
            'note' => $this->note
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
        if ($this->userId) {
            $this->userId = DB::table('user_rooms')
                ->select(DB::raw("
                   CASE 
                       WHEN NOT status = 'in' THEN NULL
                       ELSE user_id
                   END AS result
               "))
                ->where('room_id', $this->room->id)
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->value('user_id');
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
        $roomStatus = Room::join('user_rooms as ur', 'ur.room_id', '=', 'rooms.id')->where('rooms.id', $this->param)->where('ur.user_id', $this->userId)->get()->first();
        return view('livewire.detail', ['roomView' => $this->room, 'paymentDetails' => $this->paymentDetails, 'userDetailView' => $this->userDetail, 'userSelect' => $this->userSelect, 'roomStatus' => $roomStatus]);
    }
}
