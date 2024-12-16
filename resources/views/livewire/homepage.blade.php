<div>
    @if (auth()->user()->role === 'admin')
        <div class="mt-20 px-5 md:px-20 lg:px-32 grid gap-2 md:grid-cols-2 lg:grid-cols-3 mb-5">
            @if ($rooms)
                @foreach ($rooms as $room)
                    <div
                        class="w-full grid grid-cols-2 shadow-md overflow-hidden border {{ $room->status() == 'unpaid' || $room->status() == 'rejected' ? 'border-red-600 ring-2 ring-red-600 bg-red-100' : 'border-gray-200 bg-white' }} h-40 ">
                        <!-- Image Section -->
                        <div class="relative">
                            @if ($room->status() == 'available')
                                <div
                                    class="absolute flex items-center text-grey-600 text-xs gap-1 bg-white px-2 py-1 top-3 left-3 rounded-full shadow">
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
                                    class="absolute flex items-center text-yellow-600 text-xs gap-1 bg-white px-2 py-1 top-3 left-3 rounded-full shadow">
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
                                    class="absolute flex items-center text-red-600 text-xs gap-1 bg-white px-2 py-1 top-3 left-3 rounded-full shadow">
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
                                    class="absolute flex items-center text-cyan-600 text-xs gap-1 bg-white px-2 py-1 top-3 left-3 rounded-full shadow">
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
                                    class="absolute flex items-center text-green-600 text-xs gap-1 bg-white px-2 py-1 top-3 left-3 rounded-full shadow">
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
                        <div class="grid p-4 gap-1 content-start">
                            <h1 class="text-base font-semibold text-slate-700">{{ $room->number_room }}</h1>
                            <p class="text-sm text-gray-600">{{ $room->branch->name }}</p>
                            <h2 class="text-lg font-semibold text-slate-700">{{ formatRupiah($room->price) }}</h2>
                            <a href="/detail/{{ $room->id }}"
                                class="bg-primary-0 text-white text-center w-full px-3 py-2 mt-2 text-sm  hover:bg-lightPrimary-0 transition">Detail</a>
                        </div>
                    </div>
                @endforeach
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
            <div class="mt-20 mb-10 px-5 md:px-20 lg:px-32 lg:grid lg:grid-cols-3 gap-4">
                <div class='lg:col-span-2 bg-white shadow-lg p-4 relative rounded-md min-h-[60vh] mb-5 lg:mb-0'>
                    <div class="bg-primary-0 opacity-80 absolute left-5 right-5 top-5 -bottom-3 -z-10 rounded-md"></div>
                    <div class="flex justify-between">
                        <h1 class="text-lg font-bold text-primary-0">Rincian Pembayaran</h1>
                        {{-- <h1 class="text-md font-bold text-primary-0">{{auth()->user()->name}}</h1> --}}
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
                        {{-- <div class="flex justify-center mt-4">
                            {{ $payment[0]->links() }} <!-- Menampilkan links pagination -->
                        </div> --}}
                    @endif
                </div>
                <div class='lg:col-span-1 bg-white shadow-lg p-4 relative rounded-md min-h-[80vh]'>
                    <div class="bg-primary-0 opacity-80 absolute left-5 right-5 top-5 -bottom-3 -z-10 rounded-md"></div>
                    <div class="border border-gray-500 bg-gray-50 rounded-md p-2 mb-3">
                        <div class="flex justify-between items-center">
                            <h1 class="text-lg font-bold text-primary-0">Tagihan</h1>
                            <p class="text-xs font-semibold italic text-gray-600">
                                {{ formatRupiah($detail->price) }}/bulan</p>
                        </div>
                        <hr class="my-2" />
                        @if (
                            $detail->status_payment == 'unpaid' ||
                                $detail->status_payment == 'billing_proccess' ||
                                $detail->status_payment == 'rejected')
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
                                        <textarea wire:model="note"  id="note" name="note"
                                            class="form bg-white rounded-md" aria-describedby="note-error" placeholder="Catatan"></textarea>
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
                            {{-- <h1 class="text-md font-bold text-primary-0">{{auth()->user()->name}}</h1> --}}
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
            </div>
        @endif
    @endif
</div>
