<div class="relative">
    {{-- Modal Approve --}}
    <div class="{{ $isHidden }} absolute h-screen -top-4 right-0 left-0 z-[99] bg-[rgba(0,0,0,0.5)]">
        <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="flex flex-col bg-white border shadow-sm pointer-events-auto mt-24">
                <div class="flex justify-between items-center py-3 px-4 border-b ">
                    <h3 id="hs-basic-modal-label" class="font-bold text-gray-800  text-xl">
                        Approve
                    </h3>
                    <button type="button" wire:click="closeModal"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none "
                        aria-label="Close" data-hs-overlay="#hs-basic-modal">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-4 overflow-y-auto">
                    <div wire:loading
                        class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all fixed top-0 left-0 z-[50] flex items-center justify-center w-full h-full bg-gray-500 bg-opacity-50 pointer-events-none">
                        <div class="flex justify-center items-center">
                            <div class="spinner-border text-white" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    @if ($payment)
                        <div class="flex justify-end">
                            <p class="font-semibold text-slate-700">No: {{ $payment[0]['no'] }}</p>
                        </div>
                        <div class="font-semibold text-slate-700">
                            <p>Bukti Tf : </p>
                            <div class="flex justify-center border border-dashed my-2">
                                <img src="{{ url('uploads', $payment[0]['tf_image']) }}" alt="BuktiTf"
                                    width="50%" />
                            </div>
                        </div>
                        <p class="font-semibold text-slate-700">Jumlah Transfer: {{ formatRupiah($payment[0]['amount']) }}</p>
                        <p class="font-semibold text-slate-700">Tanggal Transfer: {{ $payment[0]['created_at'] }}</p>
                        <textarea wire:model.live="note" id="note" name="note"
                            class="py-3 px-4 block w-full border border-gray-200 text-sm focus:border-primary-0 focus:ring-primary-0 focus:outline-primary-0 active:border-primary-0 active:ring-primary-0 disabled:opacity-50 disabled:pointer-events-none rounded-none bg-white mt-3"
                            aria-describedby="note-error" placeholder="Catatan"></textarea>
                    @endif
                </div>
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
                    <button type="button" wire:click="reject" wire:loading.attr="disabled" wire:target="reject"
                        class="py-1 px-3 inline-flex items-center gap-x-2 text-sm font-medium border border-gray-200 bg-red-600 text-gray-50 shadow-sm hover:bg-red-500 focus:outline-none focus:bg-red-500 disabled:opacity-50 disabled:pointer-events-none ">
                        Reject
                    </button>
                    <button type="button" wire:click="approve" wire:loading.attr="disabled" wire:target="approve"
                        class="py-1 px-3 inline-flex items-center gap-x-2 text-sm font-medium border border-transparent bg-green-600 text-white hover:bg-green-700 focus:outline-none focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none">
                        Approve
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Approve --}}
    {{-- Modal Detail --}}
    <div class="{{ $isHiddenDetail }} fixed h-screen -top-3 right-0 left-0 z-[99] bg-[rgba(0,0,0,0.5)]">
        <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="flex flex-col bg-white border shadow-sm pointer-events-auto mt-24">
                <div class="bg-primary-0 flex justify-between items-center py-3 px-4 border-b relative">
                    <h3 id="hs-basic-modal-label" class="font-bold text-white text-xl">
                        Detail
                    </h3>
                    <button type="button" wire:click="closeModalDetail"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none absolute -top-2 -right-2"
                        aria-label="Close" data-hs-overlay="#hs-basic-modal">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-3">
                    @if ($paymentDetail)
                        <table class="w-full">
                            <tr>
                                <td class="w-[30%]">No Invoice</td>
                                <td class="w-[2%]">:</td>
                                <td>{{ $paymentDetail->no }}</td>
                            </tr>
                            <tr>
                                <td class="w-[30%]">Jumlah</td>
                                <td class="w-[2%]">:</td>
                                <td>{{ formatRupiah($paymentDetail->amount) }}</td>
                            </tr>
                            <tr>
                                <td class="w-[30%]">Tanggal</td>
                                <td class="w-[2%]">:</td>
                                <td>{{ formatDateIndo($paymentDetail->created_at) }}</td>
                            </tr>
                            <tr>
                                <td class="w-[30%]">Status</td>
                                <td class="w-[2%]">:</td>
                                <td
                                    class="{{ $paymentDetail->status == 'approve' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $paymentDetail->status == 'approve' ? 'Lunas' : 'Ditolak' }}</td>
                            </tr>
                        </table>

                        <div class="mt-5">
                            <div class="flex justify-center border border-dashed my-2">
                                <img src="{{ url('uploads', $paymentDetail->tf_image) }}" alt="BuktiTf"
                                    width="50%" />
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Detail --}}
    <div class="mt-4 w-full relative">
        <div class="w-full bg-gray-700 p-24"></div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#374151" fill-opacity="1" d="M0,64L1440,128L1440,0L0,0Z"></path>
        </svg>
        <div
            class="absolute top-[5rem] left-1/2 transform -translate-x-1/2 w-[90vw] grid grid-cols-1 md:grid-cols-4 gap-2">
            <div class="bg-white md:col-span-1">
                <div class="p-2 bg-primary-0">
                    <h1 class="font-bold text-4xl text-white">{{ $roomView->number_room }}</h1>
                    <p class="text-xs font-semibold text-white">{{ $roomView->branch->name }}</p>
                    <h1 class="text-md font-semibold text-white">{{ formatRupiah($roomView->price) }}</h1>
                    <div>
                        <label class="text-white">Nama Penyewa</label>
                        <select wire:model.live='userId' class="text-sm py-1 w-full">
                            <option class="rounded-none" value="">Pilih Salah Satu</option>
                            @foreach ($userSelect as $item)
                                <option class="rounded-none" value="{{ $item->id }}">{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($roomStatus)
                        {{-- @if ($roomStatus->status() == 'unpaid' || $roomStatus->status() == 'rejected')
                            <button type="button" wire:click="sendBill" wire:loading.attr="disabled"
                                wire:target="sendBill"
                                class="px-3 py-1 text-sm mt-3 font-semibold text-white bg-yellow-500 hover:bg-yellow-600">Send
                                Bill</button>
                        @endif --}}
                        @if ($roomStatus->status() == 'waiting_proccess')
                            <button wire:click="showModal"
                                class="px-3 py-1 text-sm mt-3 font-semibold text-white bg-green-600 hover:bg-green-700"
                                aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-basic-modal"
                                data-hs-overlay="#hs-basic-modal">Approve</button>
                        @endif
                    @endif
                </div>
                <div class="p-2">
                    <div class="border bg-grey-50 p-2">
                        <div class="flex justify-between">
                            <h1 class="text-lg font-bold text-grey-600">Data Diri</h1>
                        </div>
                        <hr class="my-2" />
                        @if ($userDetailView)
                            <div>
                                <img src="{{ url('uploads', $userDetailView->image_selfie) }}" alt="pp"
                                    class="mx-auto h-20 w-20 rounded-full overflow-hidden shadow-md" />
                            </div>
                            <table class="w-full text-slate-500">
                                <tr>
                                    <td class="py-1">Nama Lengkap</td>
                                    <td class="font-semibold">{{ $userDetailView->name }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1">Email</td>
                                    <td class="font-semibold">{{ $userDetailView->email }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1">Nomor HP</td>
                                    <td class="font-semibold">{{ $userDetailView->phone_number }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1">Nomor Darurat</td>
                                    <td class="font-semibold">{{ $userDetailView->emergency_phone }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1">Pekerjaan</td>
                                    <td class="font-semibold">{{ $userDetailView->job }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1">DP</td>
                                    <td class="font-semibold">
                                        {{ Number::currency($userDetailView->amount_dp, 'IDR') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1">Lama Tinggal</td>
                                    <td class="font-semibold">
                                        {{ $userDetailView->long_stay }}</tD>
                                </tr>
                                <tr>
                                    <td class="py-1">Status</td>
                                    <td class="font-semibold">
                                        {{ $userDetailView->status }}</td>
                                </tr>
                            </table>
                        @else
                            <p>Kamar Masih Kosong</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="bg-white min-h-[80vh] md:col-span-3 p-2 mb-10 md:mb-0">
                <div>
                    @if (session('message'))
                        <div class="mt-2 bg-green-100 border border-green-200 text-sm text-green-800 rounded-lg p-4 mb-4 "
                            role="alert" tabindex="-1" aria-labelledby="hs-soft-color-danger-label">
                            {{ session('message') }}
                        </div>
                    @elseif (session('message-reject'))
                        <div class="mt-2 bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 mb-4 "
                            role="alert" tabindex="-1" aria-labelledby="hs-soft-color-danger-label">
                            {{ session('message-reject') }}
                        </div>
                    @endif
                    <table
                        class="w-full border {{ $param === 'available' ? 'bg-slate-600' : 'bg-gradient-to-l from-green-500 to-green-700' }} text-gray-700">
                        <thead class="bg-primary-0 text-white">
                            <tr>
                                <th class="p-2 border border-lightPrimary-0">No</th>
                                <th class="p-2 border border-lightPrimary-0">No Invoice</th>
                                <th class="p-2 hidden md:block border border-lightPrimary-0">Date</th>
                                <th class="p-2 border border-lightPrimary-0">Status</th>
                                <th class="p-2 hidden md:block border border-lightPrimary-0">Amount</th>
                                <th class="p-2 border border-lightPrimary-0">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentDetails as $idx => $detail)
                                <tr class="bg-white hover:bg-gray-50">
                                    <td class="p-2 border border-lightPrimary-0">{{ $idx + 1 }}</td>
                                    <td class="p-2 border border-lightPrimary-0">
                                        {{ $detail->no === 'billing' ? '-' : $detail->no }}</td>
                                    <td class="p-2 hidden md:block border border-lightPrimary-0">
                                        {{ formatDateIndo($detail->updated_at) }}
                                    </td>
                                    <td class="p-2 border border-lightPrimary-0">
                                        @if ($detail->status === 'waiting_proccess')
                                            <div
                                                class="text-white bg-yellow-600 px-3 py-1 rounded-full text-xs text-center">
                                                Waiting
                                            </div>
                                        @elseif($detail->status === 'approve')
                                            <div
                                                class="text-white bg-green-600 px-3 py-1 rounded-full text-xs text-center">
                                                Paid
                                            </div>
                                        @elseif($detail->status === 'rejected')
                                            <div
                                                class="text-white bg-red-600 px-3 py-1 rounded-full text-xs text-center">
                                                Rejected
                                            </div>
                                        @elseif($detail->status === 'billing_proccess')
                                            <div
                                                class="text-white bg-cyan-600 px-3 py-1 rounded-full text-xs text-center">
                                                Billing Proccess
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-2 hidden md:block border border-lightPrimary-0">
                                        {{ formatRupiah($detail->amount) }}</td>
                                    <td class="p-2 border border-lightPrimary-0 text-center">
                                        @if ($detail->status === 'rejected' || $detail->status === 'approve')
                                            <button wire:click="getPaymentIdDetail({{ $detail->payment_id }})"
                                                class="text-green-600">
                                                <svg class="w-4 h-4" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-width="2"
                                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                    <path stroke="currentColor" stroke-width="2"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
