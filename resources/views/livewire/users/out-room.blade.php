<div class='pt-20 px-5 md:px-20 lg:px-32'>
    <a href="/" class="flex items-center text-slate-100 hover:text-slate-200 font-semibold">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m15 19-7-7 7-7" />
        </svg>
        Kembali ke beranda</a>
    <div class="bg-gray-50 px-4 py-2 mb-3 mt-4">
        <div class="flex justify-between items-center">
            <h1 class="text-lg font-bold text-primary-0">Form Pengajuan Keluar Kamar</h1>
        </div>
        <hr class="my-2" />
        @if (!$isUserOut)
            <form wire:submit.prevent='save'>
                <div class="mb-3">
                    <label for="date" class="block text-sm mb-2">Tanggal Keluar<span
                            class="text-red-600">*</span></label>
                    <div class="relative">
                        <input wire:model="date" type="date" id="date" name="date"
                            class="form bg-white rounded-md" accept="image/*" aria-describedby="date-error">
                        @error('date')
                            <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor"
                                    viewBox="0 0 16 16" aria-hidden="true">
                                    <path
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                </svg>
                            </div>
                        @enderror
                    </div>
                    @error('date')
                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                    @enderror
                </div>
                <button
                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold border border-transparent bg-primary-0 text-white hover:bg-lightPrimary-0 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 mt-3">Send</button>
            </form>
        @else
            <div class="text-slate-600 font-semibold italic">Tanggal pengajuan keluar sudah terkirim, pengembalian DP sedang diproses...</div>
        @endif
    </div>
</div>
