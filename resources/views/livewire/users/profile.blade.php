<div>
    <div class='pt-20 px-5 md:px-20 lg:px-32'>
        <a href="/" class="flex items-center text-slate-100 hover:text-slate-200 font-semibold">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m15 19-7-7 7-7" />
            </svg>
            Kembali ke beranda
        </a>

        <div class="bg-gray-50 px-4 py-2 mb-3 mt-4">
            <div class="flex justify-between items-center">
                <h1 class="text-lg font-bold text-primary-0">Profile</h1>
            </div>
            <hr class="my-2" />

            <div class="border border-grey-500 bg-grey-50 p-2">
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
                        <td class="py-1">Deposit</td>
                        <td class="font-semibold">{{ Number::currency($dp['amount'], 'IDR') }}</td>
                    </tr>
                </table>
            </div>
            <button class="bg-primary-0 p-2 mt-2 text-white w-full" wire:click="$set('showModal', true)">
                Ubah Password
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div>
        @if ($showModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
                <div class="bg-white p-6 shadow-lg w-full max-w-md">
                    <h2 class="text-xl font-bold mb-4">Ubah Password</h2>

                    @if (session()->has('success'))
                        <div class="text-green-500 mb-3">{{ session('success') }}</div>
                    @endif

                    <form wire:submit.prevent="updatePassword">
                        <!-- Password Saat Ini -->
                        <div class="mb-4 relative">
                            <label class="block text-gray-700">Password Saat Ini</label>
                            <div class="flex items-center border rounded">
                                <input type="{{ $showCurrentPassword ? 'text' : 'password' }}"
                                    wire:model.defer="current_password"
                                    class="w-full p-2 border-none focus:outline-none"
                                    placeholder="Masukkan password saat ini" />
                                <button type="button" wire:click="$toggle('showCurrentPassword')" class="p-2">
                                    @if ($showCurrentPassword)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825a5.126 5.126 0 01-7.25-7.25m11.662-2.6a9.827 9.827 0 01.35-9.85M9.121 9.121l5.758 5.758" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3.055 11a9.827 9.827 0 010-4.15M20.95 11a9.827 9.827 0 010 4.15m-4.103 4.1a5.126 5.126 0 01-7.45 0" />
                                        </svg>
                                    @endif
                                </button>
                            </div>
                            @error('current_password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-4 relative">
                            <label class="block text-gray-700">Password Baru</label>
                            <div class="flex items-center border rounded">
                                <input type="{{ $showNewPassword ? 'text' : 'password' }}"
                                    wire:model.defer="new_password" class="w-full p-2 border-none focus:outline-none"
                                    placeholder="Masukkan password baru" />
                                <button type="button" wire:click="$toggle('showNewPassword')" class="p-2">
                                    @if ($showNewPassword)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825a5.126 5.126 0 01-7.25-7.25m11.662-2.6a9.827 9.827 0 01.35-9.85M9.121 9.121l5.758 5.758" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3.055 11a9.827 9.827 0 010-4.15M20.95 11a9.827 9.827 0 010 4.15m-4.103 4.1a5.126 5.126 0 01-7.45 0" />
                                        </svg>
                                    @endif
                                </button>
                            </div>
                            @error('new_password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mb-4">
                            <label class="block text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" wire:model.defer="new_password_confirmation"
                                class="w-full p-2 border focus:outline-none"
                                placeholder="Masukkan ulang password baru" />
                            @error('new_password_confirmation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex gap-2">
                            <button type="submit" class="w-full bg-gray-600 text-white py-2 px-4 hover:bg-gray-700">
                                Simpan Perubahan
                            </button>
                            <div wire:click="close" class="w-full cursor-pointer bg-red-600 text-white py-2 px-4 hover:bg-red-700 text-center">Batal
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
