<div class='pt-20 px-5 md:px-20 lg:px-32'>
    <div class='bg-white p-3'>
        <a href="/" class="flex items-center hover:text-primary-0 font-semibold">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m15 19-7-7 7-7" />
            </svg>
            Kembali ke beranda</a>
        @if (session('message'))
            <div class="mt-2 bg-green-100 border border-green-200 text-sm text-green-800 rounded-lg p-4 mb-4 "
                role="alert" tabindex="-1" aria-labelledby="hs-soft-color-danger-label">
                {{ session('message') }}
            </div>
        @endif
        <div class="mt-3">
            @if ($payments->isEmpty())
                <p class="text-center text-gray-700">Belum Ada Pembayaran yang diberikan, <a href="/pay-rent" class="text-blue-500 hover:text-blue-600">silahkan lakukan
                    pembayaran</a></p>
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
                                        <div class="text-white bg-green-600 px-3 py-1 rounded-full text-xs text-center">
                                            Lunas
                                        </div>
                                    @elseif($payment->status === 'rejected')
                                        <div class="text-white bg-red-600 px-3 py-1 rounded-full text-xs text-center">
                                            Ditolak
                                        </div>
                                    @elseif($payment->status === 'billing_proccess')
                                        <div class="text-white bg-cyan-600 px-3 py-1 rounded-full text-xs text-center">
                                            Penagihan
                                        </div>
                                    @endif
                                </td>
                                <td class="p-2 border border-primary-0 text-center">
                                    <button class="text-primary-0">
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
                <div class="mt-4">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
