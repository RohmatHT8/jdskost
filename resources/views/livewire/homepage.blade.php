<div>
    @if (auth()->user()->role === 'admin')
        <div class="mt-20 px-5 md:px-20 lg:px-32 grid gap-2 md:grid-cols-2 lg:grid-cols-3 mb-5">
            @if ($rooms)
                <div wire:loading class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-10">
                    <div class="text-white text-lg mt-40">
                        <svg class="animate-spin h-8 w-8 text-white mx-auto mb-4" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-16 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                @foreach ($rooms as $room)
                    {{-- <p>{{!empty($room->payments) ? $room->payments : 'kosong'}}</p> --}}
                    <div wire:loading.remove
                        class="w-full grid grid-cols-2 shadow-md overflow-hidden border {{ $room->status() == 'unpaid' || $room->status() == 'rejected' ? 'border-red-600 ring-2 ring-red-600 bg-red-100' : 'border-gray-200 bg-white' }} md:h-full">
                        <!-- Image Section -->
                        <div class="relative">
                            @if ($room->status() == 'available')
                                <div
                                    class="absolute flex items-center z-20 text-grey-600 text-xs gap-1 bg-white px-2 py-1 top-3 left-3 rounded-full shadow">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 0 0-.822 1.57L6.632 12l-4.454 6.43A1 1 0 0 0 3 20h13.153a1 1 0 0 0 .822-.43l4.847-7a1 1 0 0 0 0-1.14l-4.847-7a1 1 0 0 0-.822-.43H3Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p>Available</p>
                                </div>
                            @elseif($room->status() == 'waiting_proccess')
                                <div
                                    class="absolute flex items-center z-20 text-yellow-600 text-xs gap-1 bg-white px-2 py-1 top-3 left-3 rounded-full shadow">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 0 0-.822 1.57L6.632 12l-4.454 6.43A1 1 0 0 0 3 20h13.153a1 1 0 0 0 .822-.43l4.847-7a1 1 0 0 0 0-1.14l-4.847-7a1 1 0 0 0-.822-.43H3Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p>Proccess</p>
                                </div>
                            @elseif($room->status() == 'unpaid' || $room->status() == 'rejected')
                                <div
                                    class="absolute flex items-center z-20 text-red-600 text-xs gap-1 bg-white px-2 py-1 top-3 left-3 rounded-full shadow">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 0 0-.822 1.57L6.632 12l-4.454 6.43A1 1 0 0 0 3 20h13.153a1 1 0 0 0 .822-.43l4.847-7a1 1 0 0 0 0-1.14l-4.847-7a1 1 0 0 0-.822-.43H3Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p>Un Paid</p>
                                </div>
                            @elseif($room->status() == 'billing_proccess')
                                <div
                                    class="absolute flex items-center z-20 text-cyan-600 text-xs gap-1 bg-white px-2 py-1 top-3 left-3 rounded-full shadow">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 0 0-.822 1.57L6.632 12l-4.454 6.43A1 1 0 0 0 3 20h13.153a1 1 0 0 0 .822-.43l4.847-7a1 1 0 0 0 0-1.14l-4.847-7a1 1 0 0 0-.822-.43H3Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p>Billing Proccess</p>
                                </div>
                            @elseif($room->status() == 'approve')
                                <div
                                    class="absolute flex items-center z-20 text-green-600 text-xs gap-1 bg-white px-2 py-1 top-3 left-3 rounded-full shadow">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 0 0-.822 1.57L6.632 12l-4.454 6.43A1 1 0 0 0 3 20h13.153a1 1 0 0 0 .822-.43l4.847-7a1 1 0 0 0 0-1.14l-4.847-7a1 1 0 0 0-.822-.43H3Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p>Paid</p>
                                </div>
                            @endif

                            <img src="{{ url('uploads/', $room->image_room) }}" alt="Room Image"
                                class="w-full h-full object-cover" />
                        </div>
                        <!-- Content Section -->
                        <div class="grid p-4 gap-1 content-start relative">
                            @if ($room->isBook())
                                <div class="absolute bg-green-600 top-0 right-0 text-white px-3 text-xs py-1 text-end">
                                    Booked</div>
                            @endif
                            <h1 class="text-base font-semibold text-slate-700">{{ $room->number_room }}</h1>
                            <p class="text-sm text-gray-600">{{ $room->branch->name }}</p>
                            <h2 class="text-lg font-semibold text-slate-700">{{ formatRupiah($room->price) }}</h2>
                            @if ($room->status() !== 'available')
                                <p class="text-xs font-semibold text-amber-800">
                                    Pembayaran Setiap Tanggal
                                    {{ empty($room->payments[0]) ? '-' : $room->payments[0]->anual_payment }}</p>
                            @endif
                            <a href="/detail/{{ $room->id }}"
                                class="bg-primary-0 text-white text-center w-full px-3 py-2 mt-2 text-sm  hover:bg-lightPrimary-0 transition">Detail</a>
                        </div>
                    </div>
                @endforeach
                {{-- <div class="mt-4">
                    {{ $rooms->links() }}
                </div> --}}
            @else
                <div class="w-full rounded-md border border-dashed p-5 col-span-3 text-center text-gray-500">
                    Tidak Ada Data
                </div>
            @endif
        </div>
    @else
        @if (!$detail)
            <div class="mt-24 text-center font-bold text-primary-0">Anda Tidak Terdaftar di JDS Kost</div>
        @else
            {{-- yang dulu --}}
            {{-- <div class="mt-20 mb-10 px-5 md:px-20 lg:px-32 lg:grid lg:grid-cols-3 gap-4">
                <div class='lg:col-span-2 bg-white shadow-lg p-4 relative rounded-md min-h-[60vh] mb-5 lg:mb-0'>
                    <div wire:loading
                        class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-10">
                        <div class="text-white text-lg mt-40">
                            <svg class="animate-spin h-8 w-8 text-white mx-auto mb-4" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-16 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div wire:loading.remove
                        class="bg-primary-0 opacity-80 absolute left-5 right-5 top-5 -bottom-3 -z-10 rounded-md"></div>
                    <div class="flex justify-between">
                        <h1 class="text-lg font-bold text-primary-0">Rincian Pembayaran</h1>
                    </div>
                    <hr class="my-2" />
                    @if ($payments->isEmpty())
                        <p class="text-center text-gray-700">Belum Ada Pembayaran yang diberikan, silahkan lakukan
                            pembayaran</p>
                    @else
                        <table class="w-full border bg-gray-400 text-gray-700 rounded-md">
                            <thead class="bg-gray-500 text-white">
                                <tr>
                                    <th class="p-2 border border-primary-0">No</th>
                                    <th class="p-2 border border-primary-0">No Invoice</th>
                                    <th class="p-2 border border-primary-0">Tanggal</th>
                                    <th class="p-2 border border-primary-0">Status</th>
                                    <th class="p-2 border border-primary-0">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $idx => $payment)
                                    <tr class="bg-white hover:bg-gray-50">
                                        <td class="p-2 border border-primary-0 text-center">{{ $idx + 1 }}</td>
                                        <td class="p-2 border border-primary-0 text-center">
                                            {{ $payment->no == 'billing' ? 'Penagihan' : $payment->no }}</td>
                                        <td class="p-2 border border-primary-0 text-center">
                                            {{ formatDateIndo($payment->created_at) }}</td>
                                        <td class="p-2 border border-primary-0">
                                            @if ($payment->status === 'waiting_proccess')
                                                <div
                                                    class="text-white bg-yellow-600 px-3 py-1 rounded-full text-xs text-center">
                                                    Menunggu Konfirmasi
                                                </div>
                                            @elseif($payment->status === 'approve')
                                                <div
                                                    class="text-white bg-green-600 px-3 py-1 rounded-full text-xs text-center">
                                                    Lunas
                                                </div>
                                            @elseif($payment->status === 'rejected')
                                                <div
                                                    class="text-white bg-red-600 px-3 py-1 rounded-full text-xs text-center">
                                                    Ditolak
                                                </div>
                                            @elseif($payment->status === 'billing_proccess')
                                                <div
                                                    class="text-white bg-cyan-600 px-3 py-1 rounded-full text-xs text-center">
                                                    Penagihan
                                                </div>
                                            @endif
                                        </td>
                                        <td class="p-2 border border-primary-0 text-center">
                                            <button class="text-primary-0">
                                                <svg class="w-4 h-4" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-width="2"
                                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                    <path stroke="currentColor" stroke-width="2"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class='lg:col-span-1 bg-white shadow-lg p-4 relative rounded-md min-h-[80vh]'>
                    <div class="bg-primary-0 opacity-80 absolute left-5 right-5 top-5 -bottom-3 -z-10 rounded-md">
                    </div>
                    <div class="border border-gray-500 bg-gray-50 rounded-md p-2 mb-3">
                        <div class="flex justify-between items-center">
                            <h1 class="text-lg font-bold text-primary-0">Tagihan</h1>
                            <p class="text-xs font-semibold italic text-gray-600">
                                {{ formatRupiah($detail->price) }}/bulan</p>
                        </div>
                        <hr class="my-2" />
                        @if ($detail->status_payment == 'unpaid' || $detail->status_payment == 'billing_proccess' || $detail->status_payment == 'rejected')
                            <form wire:submit.prevent="savePayment">
                                <div class="mb-3">
                                    <label for="amount" class="block text-sm mb-2">Jumlah
                                        Pembayaran<span class="text-red-600">*</span></label>
                                    <div class="relative">
                                        <input wire:model="amount" type="number" id="amount" name="amount"
                                            class="form bg-white rounded-md" aria-describedby="amount-error">
                                        @error('amount')
                                            <div
                                                class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                                <svg class="h-5 w-5 text-red-500" width="16" height="16"
                                                    fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                    <path
                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                                </svg>
                                            </div>
                                        @enderror
                                    </div>
                                    @error('amount')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="tf_image" class="block text-sm mb-2">Upload Bukti
                                        Transfer<span class="text-red-600">*</span></label>
                                    <div class="relative">
                                        <input wire:model="tf_image" type="file" id="tf_image" name="tf_image"
                                            class="form bg-white rounded-md" accept="image/*"
                                            aria-describedby="tf_image-error">
                                        @error('tf_image')
                                            <div
                                                class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                                <svg class="h-5 w-5 text-red-500" width="16" height="16"
                                                    fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                    <path
                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                                </svg>
                                            </div>
                                        @enderror
                                    </div>
                                    @error('tf_image')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="block text-sm mb-2">Catatan</label>
                                    <div class="relative">
                                        <textarea wire:model="note" id="note" name="note" class="form bg-white rounded-md"
                                            aria-describedby="note-error" placeholder="Catatan"></textarea>
                                        @error('note')
                                            <div
                                                class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                                <svg class="h-5 w-5 text-red-500" width="16" height="16"
                                                    fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                    <path
                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                                </svg>
                                            </div>
                                        @enderror
                                    </div>
                                    @error('note')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button
                                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold border border-transparent bg-primary-0 text-white hover:bg-lightPrimary-0 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 rounded-md mt-3">Send</button>
                            </form>
                        @else
                            <div>
                                <svg class="w-6 h-6 text-lightPrimary-0 opacity-50 mb-0 text-center mx-auto"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                </svg>

                                <p class="mb-2 text-center font-semibold text-xs text-lightPrimary-0 opacity-50">Tidak
                                    Ada
                                    Tagihan
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="border border-grey-500 bg-grey-50 rounded-md p-2">
                        <div class="flex justify-between">
                            <h1 class="text-lg font-bold text-grey-600">Data Diri</h1>
                        </div>
                        <hr class="my-2" />
                        <table class="w-full text-slate-500">
                            <tr>
                                <td class="py-1">Nama Lengkap</td>
                                <td class="font-semibold">{{ $detail->name }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">Nomor Kamar</td>
                                <td class="font-semibold">{{ $detail->number_room }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">Email</td>
                                <td class="font-semibold">{{ $detail->email }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">Nomor HP</td>
                                <td class="font-semibold">{{ $detail->phone_number }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">Nomor Darurat</td>
                                <td class="font-semibold">{{ $detail->emergency_phone }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">Pekerjaan</td>
                                <td class="font-semibold">{{ $detail->job }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">DP</td>
                                <td class="font-semibold">{{ Number::currency($detail->amount_dp, 'IDR') }}</td>
                            </tr>
                            <tr>
                                <td class="py-1">Status</td>
                                <td class="font-semibold">{{ $detail->status }}</td>
                            </tr>
                        </table>
                        <p class="text-red-500 italic text-xs">*Default Password: Nama depan dimulai huruf besar, tgl
                            masuk/bulan masuk cth: User22/11</p>
                    </div>
                </div>
            </div> --}}
            {{-- akhir yang dulu --}}
            <div class="w-full pb-3 mt-10 pt-12 px-5 md:px-20 lg:px-32  text-slate-200">
                <p class="font-bold text-lg md:text-2xl">Hi, {{ $detail[0]->name }}</p>
                <p class="text-xs font-semibold text-slate-300 md:text-base">Nomor Kamar {{ $detail[0]->number_room }}
                    ({{ $detail[0]->status }}) {{ $detail[0]->date_out }}</p>
                <p class="text-xs font-semibold text-slate-300 md:text-base">Tenggat waktu bayar setiap tanggal
                    {{ $detail[0]->anual_payment }}</p>
                <p class="text-xs font-semibold text-slate-300 md:text-base italic">Biaya sewa perbulan
                    {{ formatRupiah($detail[0]->price) }}</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-5 px-5 md:px-20 lg:px-32">
                <a href="/detail-payment"
                    class='w-full py-5 bg-slate-200 px-3 flex flex-col justify-center items-center hover:bg-slate-300 hover:shadow-lg cursor-pointer transition-all'>
                    <img src="{{ asset('assets/rincian-pembayaran.png') }}" alt="rincian-pembayaran"
                        class='max-w-32' />
                    <p class="text-gray-700 font-bold">Rincian Pembayaran</p>
                </a>
                <a href="/pay-rent"
                    class='w-full py-5 bg-slate-200 px-3 flex flex-col justify-center items-center hover:bg-slate-300 hover:shadow-lg cursor-pointer transition-all'>
                    <img src="{{ asset('assets/bayar-sewa.png') }}" alt="bayar-sewa" class='max-w-32' />
                    <p class="text-gray-700 font-bold">Bayar Sewa</p>
                </a>
                <a href="/profile"
                    class='w-full py-5 bg-slate-200 px-3 flex flex-col justify-center items-center hover:bg-slate-300 hover:shadow-lg cursor-pointer transition-all'>
                    <img src="{{ asset('assets/data-diri.png') }}" alt="data-diri" class='max-w-32' />
                    <p class="text-gray-700 font-bold">Data Diri</p>
                </a>
                <a href='/out-room'
                    class='w-full py-5 bg-slate-200 px-3 flex flex-col justify-center items-center hover:bg-slate-300 hover:shadow-lg cursor-pointer transition-all'>
                    <img src="{{ asset('assets/keluar-kamar.png') }}" alt="keluar-kamar" class='max-w-32' />
                    <p class="text-gray-700 font-bold">Check Out</p>
                </a>
            </div>
            <div class="px-5 md:px-20 lg:px-32 mt-3 mb-10">
                <div class="border px-3 py-2 bg-gray-700 md:grid md:grid-cols-3">
                    <div class="md:col-span-2 md:pr-3">
                        <h1 class="text-white font-bold text-lg mb-3">TATA TERTIB JDS KOST</h1>
                        <div class="flex gap-2 text-sm mb-2 text-slate-700">
                            <div class="bg-yellow-300 font-bold rounded-full flex justify-center items-center flex-none"
                                style="height: 25px; width: 25px;">
                                <p>1</p>
                            </div>
                            <div class="text-slate-300">
                                <p>Standard dan deluxe hanya untuk 1 orang, Executive maks 2 orang.</p>
                            </div>
                        </div>
                        <div class="flex gap-2 text-sm mb-2 text-slate-700">
                            <div class="bg-yellow-300 font-bold rounded-full flex justify-center items-center flex-none"
                                style="height: 25px; width: 25px;">
                                <p class="text-slate-600">2</p>
                            </div>
                            <div>
                                <p class="text-slate-300">Simpan dan jaga barang pribadi dengan baik. Kehilangan barang
                                    menjadi tangung jawab pribadi penghuni.</p>
                            </div>
                        </div>
                        <div class="flex gap-2 text-sm mb-2 text-slate-700">
                            <div class="bg-yellow-300 font-bold rounded-full flex justify-center items-center flex-none"
                                style="height: 25px; width: 25px;">
                                <p class="text-slate-600">3</p>
                            </div>
                            <div>
                                <p class="text-slate-300">dilarang melakukan hal-hal yang bertentangan dengan norma
                                    hukum.</p>
                            </div>
                        </div>
                        <div class="flex gap-2 text-sm mb-2 text-slate-700">
                            <div class="bg-yellow-300 font-bold rounded-full flex justify-center items-center flex-none"
                                style="height: 25px; width: 25px;">
                                <p class="text-slate-600">4</p>
                            </div>
                            <div>
                                <p class="text-slate-300">jaga ketertiban umum dan kenyamanan Bersama, saling
                                    menghormati dan menghargai sesama penghuni JDS Kost Kelapa Gading</p>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-1">
                        <h1 class="text-white font-bold text-lg mb-3">Penggunaan Fasilitas Bersama</h1>
                        <div class="flex gap-2 text-sm mb-2 text-slate-700">
                            <div class="bg-yellow-300 font-bold rounded-full flex justify-center items-center flex-none"
                                style="height: 25px; width: 25px;">
                                <p>1</p>
                            </div>
                            <div class="text-slate-300">
                                <p>penghuni wajib mennjaga seluruh fasilitas kost yang ada.</p>
                            </div>
                        </div>
                        <div class="flex gap-2 text-sm mb-2 text-slate-700">
                            <div class="bg-yellow-300 font-bold rounded-full flex justify-center items-center flex-none"
                                style="height: 25px; width: 25px;">
                                <p class="text-slate-600">2</p>
                            </div>
                            <div>
                                <p class="text-slate-300">harap memeriksa Kembali KOMPOR GAS setelah penggunaan
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2 text-sm mb-2 text-slate-700">
                            <div class="bg-yellow-300 font-bold rounded-full flex justify-center items-center flex-none"
                                style="height: 25px; width: 25px;">
                                <p class="text-slate-600">3</p>
                            </div>
                            <div>
                                <p class="text-slate-300">penghuni harap mematikan penggunaan elektronik dan air jika
                                    tidak digunakan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
