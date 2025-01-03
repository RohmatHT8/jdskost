@php
    $classForm =
        'py-3 px-4 block w-full border border-gray-200 text-sm focus:border-primary-0 focus:ring-primary-0 active:border-primary-0 active:ring-primary-0 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-primary-0';
@endphp
<section class="flex justify-center items-center min-h-screen bg-gradient-to-tr from-gray-50 to-gray-100">
    <div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="flex h-full items-center">
            <main class="w-full max-w-md mx-auto p-6">
                <div class="bg-white border border-gray-200 shadow-lg">
                    <div class="p-4 sm:p-7">
                        <div class="text-center">
                            <img src="{{ asset('assets/logo.png') }}" class="h-10 mx-auto" alt="logo" />
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                sudah memiliki akun?
                                <a href="/login"
                                    class="text-primary-0 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                    href="/register">
                                    Masuk
                                </a>
                            </p>
                        </div>

                        <hr class="my-5 border-slate-300">

                        <!-- Form -->
                        <form wire:submit="save">
                            <div class="grid gap-y-4">
                                <!-- Form Group -->
                                <div>
                                    <label for="name" class="block text-sm mb-2">Nama Lengkap
                                        (sesuai KTP)<span class="text-red-600">*</span></label>
                                    <div class="relative">
                                        <input wire:model="name" type="text" id="name" name="name"
                                            class="form" placeholder="Nama Lengkap" aria-describedby="name-error">
                                        @error('name')
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
                                    @error('name')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->
                                <!-- Form Group -->
                                <div>
                                    <label for="email" class="block text-sm mb-2">Email</label>
                                    <div class="relative">
                                        <input wire:model="email" type="email" id="email" name="email"
                                            class="form" aria-describedby="email-error"
                                            placeholder="example@gmail.com">
                                        @error('email')
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
                                    @error('email')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->
                                <!-- Form Group -->
                                <div>
                                    <label for="job" class="block text-sm mb-2">Pekerjaan</label>
                                    <div class="relative">
                                        <input wire:model="job" type="text" id="job" name="job"
                                            class="form" aria-describedby="job-error" placeholder="Pekerjaan">
                                        @error('job')
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
                                    @error('job')
                                        <p class="text-xs text-red-600 mt-2" id="job-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->
                                <!-- Form Group -->
                                <div class="flex justify-between gap-1">
                                    <div class="w-full">
                                        <label for="branch_id" class="block text-sm mb-2">Cabang<span
                                                class="text-red-600">*</span></label>
                                        <div class="relative">
                                            <select wire:model.live="branch_id" id="branch_id" name="branch_id"
                                                class="form">
                                                <option value="">Pilih Salah Satu</option>
                                                @foreach ($branches as $branch)
                                                    <option value={{ $branch->id }}>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('branch_id')
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
                                        @error('branch_id')
                                            <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-full">
                                        <label for="status" class="block text-sm mb-2">Peruntukan<span
                                                class="text-red-600">*</span></label>
                                        <div class="relative">
                                            <select wire:model.live="status" id="status" name="status"
                                                class="form">
                                                <option value="">Pilih Salah Satu</option>
                                                <option value='in'>Langsung Masuk</option>
                                                <option value='book'>Booking</option>
                                            </select>
                                            @error('status')
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
                                        @error('status')
                                            <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="{{ $branch_id && $status ? '' : 'hidden' }}">
                                    <label for="room_id" class="block text-sm mb-2">Nomor
                                        Ruangan<span class="text-red-600">*</span></label>
                                    <div class="relative">
                                        <select wire:model="room_id" id="room_id" name="room_id" class="form">
                                            <option value="">Pilih Salah Satu</option>
                                            @foreach ($rooms as $room)
                                                <option value={{ $room->id }}>{{ $room->number_room }}</option>
                                            @endforeach
                                        </select>
                                        @error('room_id')
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
                                    @error('room_id')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-between gap-2">
                                    <div class="w-full">
                                        <label for="date_in" class="block text-sm mb-2">Tanggal
                                            Masuk<span class="text-red-600">*</span></label>
                                        <div class="relative">
                                            <input wire:model="date_in" type="date" id="date_in" name="date_in"
                                                class="form" aria-describedby="date_in-error"
                                                placeholder="Pekerjaan">
                                            @error('date_in')
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
                                        @error('date_in')
                                            <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div>
                                    <label for="image_ktp" class="block text-sm mb-2">KTP Image<span
                                            class="text-red-600">*</span></label>
                                    <div class="relative" id='statusMessage'>
                                        <input wire:model="image_ktp" class="form" type="file" accept="image/*"
                                            name="image_ktp" aria-describedby="image_ktp-error">
                                        @error('image_ktp')
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
                                    @error('image_ktp')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div>
                                    <label for="phone_number" class="block text-sm mb-2">Nomor WA<span
                                            class="text-red-600">*</span></label>
                                    <div class="relative">
                                        <input wire:model="phone_number" type="text" id="phone_number"
                                            name="phone_number" class="form" placeholder="Nomor WA"
                                            aria-describedby="phone_number-error">
                                        @error('phone_number')
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
                                    @error('phone_number')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div>
                                    <label for="emergency_phone" class="block text-sm mb-2">Nama Dan
                                        Nomor Telepon Darurat<span class="text-red-600">*</span></label>
                                    <div class="relative">
                                        <input wire:model="emergency_phone" type="text" id="emergency_phone"
                                            name="emergency_phone" class="form"
                                            placeholder="Nama Lengkap (0857xxxxxx)"
                                            aria-describedby="emergency_phone-error">
                                        @error('emergency_phone')
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
                                    @error('emergency_phone')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div>
                                    <label for="image_selfie" class="block text-sm mb-2">Swafoto (Foto
                                        Selfie)<span class="text-red-600">*</span></label>
                                    <div class="relative">
                                        <input wire:model="image_selfie" type="file" accept="image/*"
                                            id="image_selfie" name="image_selfie" class="form"
                                            placeholder="Nama Lengkap" aria-describedby="image_selfie-error">
                                        @error('image_selfie')
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
                                    @error('image_selfie')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div>
                                    <label for="long_stay" class="block text-sm mb-2">Saya Akan
                                        Tinggal
                                        di JDS Kost untuk waktu<span class="text-red-600">*</span></label>
                                    <div class="relative">
                                        <select wire:model="long_stay" id="long_stay" name="long_stay"
                                            class="form">
                                            <option value="">Pilih Salah Satu</option>
                                            <option value="Kurang dari 3 Bulan">Kurang dari 3 Bulan</option>
                                            <option value="3 Bulan">3 Bulan</option>
                                            <option value="6 Bulan">6 Bulan</option>
                                            <option value="1 Tahun">1 Tahun</option>
                                            <option value="Lebih dari 1 Tahun">Lebih dari 1 Tahun</option>
                                        </select>
                                        @error('long_stay')
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
                                    @error('long_stay')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div>
                                    <label for="amount_dp" class="block text-sm mb-2">Jumlah Dp <span
                                            class="text-red-600">*</span></label>
                                    <div class="relative">
                                        <input wire:model="amount_dp" type="number" id="amount_dp" name="amount_dp"
                                            class="form" placeholder="Jumlah DP"
                                            aria-describedby="amount_dp-error">
                                        @error('amount_dp')
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
                                    @error('amount_dp')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div>
                                    <label for="image_dp" class="block text-sm mb-2">Upload Bukti
                                        Transfer Deposit<span class="text-red-600">*</span></label>
                                    <div class="relative">
                                        <input wire:model="image_dp" type="file" accept="image/*" id="image_dp"
                                            name="image_dp" class="form" aria-describedby="image_dp-error">
                                        @error('image_dp')
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
                                    @error('image_dp')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->
                                <div class="p-2 flex justify-start items-start gap-2 border">
                                    <input wire:model="aggrement" type="checkbox" id="aggrement" name="aggrement"
                                        class="mt-1" aria-describedby="aggrement-error">
                                    <p class="text-xs text-slate-600 italic">Dengan ini, saya menyatakan bahwa semua
                                        data yang saya berikan adalah benar, lengkap, dan sesuai dengan kondisi saya
                                        saat ini. Saya juga menyetujui penggunaan data ini sesuai dengan ketentuan dan
                                        kebijakan yang berlaku. Saya mengerti bahwa kesalahan atau ketidaksesuaian data
                                        yang diberikan adalah tanggung jawab saya sepenuhnya.</p>
                                </div>
                                @error('aggrement')
                                    <p class="text-xs text-red-600" id="aggrement-error">{{ $message }}</p>
                                @enderror
                                <button
                                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold border border-transparent bg-primary-0 text-white hover:bg-lightPrimary-0 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Daftar</button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>

<script>
    // document.getElementById('image_ktp').addEventListener('change', function(event) {
    //     const file = event.target.files[0];
    //     if (file) {
    //         const formData = new FormData();
    //         formData.append('image', file);

    //         axios.post('/upload-image', formData, {
    //                 headers: {
    //                     'Content-Type': 'multipart/form-data',
    //                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //                 }
    //             })
    //             .then(response => {
    //                 if (response.data.status === 'success') {
    //                     document.getElementById('statusMessage').innerHTML +=
    //                     `<div class="w-full flex justify-center p-2 border border-dotted mt-2" ><img src="${response.data.file_name}" class="w-[20%]" /></div>`
    //                 }
    //             })
    //             .catch(error => {
    //                 console.error('Error uploading image:', error);
    //                 document.getElementById('statusMessage').innerText = 'Failed to upload image.';
    //             });
    //     }
    // });
</script>
