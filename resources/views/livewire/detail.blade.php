<div class="relative">
    <div class="{{ $isHidden }} absolute h-screen -top-4 right-0 left-0 z-[99] bg-[rgba(0,0,0,0.5)]">
        <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div
                class="flex flex-col bg-white border shadow-sm pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70 mt-24">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                    <h3 id="hs-basic-modal-label" class="font-bold text-gray-800 dark:text-white text-xl">
                        Approve
                    </h3>
                    <button type="button" wire:click="closeModal"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
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
                            <p>No: {{ $payment[0]['no'] }}</p>
                        </div>
                        <div>
                            <p>Bukti Tf : </p>
                            <div class="flex justify-center border border-dashed my-2">
                                <img src="{{ url('uploads', $payment[0]['tf_image']) }}" alt="BuktiTf"
                                    width="50%" />
                            </div>
                        </div>
                        <p>Jumlah Transfer: {{ formatRupiah($payment[0]['amount']) }}</p>
                        <p>Tanggal Transfer: {{ $payment[0]['created_at'] }}</p>
                    @endif
                </div>
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700">
                    <button type="button" wire:click="reject" wire:loading.attr="disabled" wire:target="reject"
                        class="py-1 px-3 inline-flex items-center gap-x-2 text-sm font-medium border border-gray-200 bg-red-600 text-gray-50 shadow-sm hover:bg-red-500 focus:outline-none focus:bg-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-red-800 dark:border-red-700 dark:text-white dark:hover:bg-red-700 dark:focus:bg-red-700">
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
    <div class="mt-4 w-full relative">
        <div class="w-full bg-green-700 p-24"></div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#15803d" fill-opacity="1" d="M0,64L1440,128L1440,0L0,0Z"></path>
        </svg>
        <div
            class="bg-white absolute top-[22rem] left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-[80vh] w-[95vw] md:w-[70%] z-30 px-10 py-5 shadow-lg overflow-x-auto">
            <h1 class="font-bold text-4xl text-green-600">{{ $room->number_room }}</h1>
            <p class="text-xs font-semibold text-gray-600">{{ $room->branch->name }}</p>
            <h1 class="text-md font-semibold text-slate-700">Rp. 1.500.000</h1>
            @if ($room->status() == 'unpaid' || $room->status() == 'rejected')
                <button type="button" wire:click="sendBill" wire:loading.attr="disabled" wire:target="sendBill"
                    class="px-3 py-1 text-sm mt-3 font-semibold text-white bg-yellow-500 hover:bg-yellow-600">Send
                    Bill</button>
            @endif
            @if ($room->status() == 'waiting_proccess')
                <button wire:click="showModal"
                    class="px-3 py-1 text-sm mt-3 font-semibold text-white bg-green-600 hover:bg-green-700"
                    aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-basic-modal"
                    data-hs-overlay="#hs-basic-modal">Approve</button>
            @endif
            <div class="mt-5">
                @if (session('message'))
                    <div class="mt-2 bg-green-100 border border-green-200 text-sm text-green-800 rounded-lg p-4 mb-4 dark:bg-green-800/10 dark:border-green-900 dark:text-green-500"
                        role="alert" tabindex="-1" aria-labelledby="hs-soft-color-danger-label">
                        {{ session('message') }}
                    </div>
                @endif
                <table
                    class="w-full border {{ $param === 'available' ? 'bg-slate-600' : 'bg-gradient-to-l from-green-500 to-green-700' }} text-gray-700">
                    <thead class="bg-green-500 text-white">
                        <tr>
                            <th class="p-2 border border-green-600">No</th>
                            <th class="p-2 border border-green-600">No Invoice</th>
                            <th class="p-2 border border-green-600">Date</th>
                            <th class="p-2 border border-green-600">Name </th>
                            <th class="p-2 border border-green-600">Status</th>
                            <th class="p-2 border border-green-600">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paymentDetails as $idx => $detail)
                            <tr class="bg-white hover:bg-green-50">
                                <td class="p-2 border border-green-600">{{ $idx + 1 }}</td>
                                <td class="p-2 border border-green-600">
                                    {{ $detail->no === 'billing' ? '-' : $detail->no }}</td>
                                <td class="p-2 border border-green-600">{{ formatDateIndo($detail->updated_at) }}</td>
                                <td class="p-2 border border-green-600">{{ formatRupiah($detail->amount) }}</td>
                                <td class="p-2 border border-green-600">
                                    @if ($detail->status === 'waiting_proccess')
                                        <div
                                            class="text-white bg-yellow-600 px-3 py-1 rounded-full text-xs text-center">
                                            Waiting
                                        </div>
                                    @elseif($detail->status === 'approve')
                                        <div class="text-white bg-green-600 px-3 py-1 rounded-full text-xs text-center">
                                            Paid
                                        </div>
                                    @elseif($detail->status === 'rejected')
                                        <div class="text-white bg-red-600 px-3 py-1 rounded-full text-xs text-center">
                                            Rejected
                                        </div>
                                    @elseif($detail->status === 'billing_proccess')
                                        <div class="text-white bg-cyan-600 px-3 py-1 rounded-full text-xs text-center">
                                            Billing Proccess
                                        </div>
                                    @endif
                                </td>
                                <td class="p-2 border border-green-600 text-center">
                                    <button class="text-green-600">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
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
            </div>
        </div>
    </div>
</div>
