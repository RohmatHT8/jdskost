<section class="flex justify-center items-center h-screen bg-gradient-to-tr from-gray-50 to-gray-100">
    <div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="flex h-full items-center">
            <main class="w-full max-w-md mx-auto p-6">
                <div class="bg-white border border-gray-200 shadow-lg">
                    <div class="p-4 sm:p-7">
                        <div class="text-center">
                            <h1 class="font-bold text-4xl text-gray-800">JDS <span class="text-primary-0">KOST</span></h1>
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
                            @if (session('error'))
                                <div class="mt-2 bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 mb-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500"
                                    role="alert" tabindex="-1" aria-labelledby="hs-soft-color-danger-label">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="grid gap-y-4">
                                <!-- Form Group -->
                                <div>
                                    <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
                                    <div class="relative">
                                        <input wire:model="password" type="password" id="password" name="password"
                                            class="form" placeholder="Password" required aria-describedby="password-error">
                                        @error('password')
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
                                    @error('password')
                                        <p class="text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->
                                <!-- Form Group -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm mb-2 dark:text-white">Password Confirmation</label>
                                    <div class="relative">
                                        <input wire:model="password_confirmation" type="password" id="password_confirmation" name="password_confirmation"
                                            class="form" placeholder="Password Confirmation" required aria-describedby="password_confirmation-error">
                                        @error('password_confirmation')
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
                                    @error('password_confirmation')
                                        <p class="text-xs text-red-600 mt-2" id="password_confirmation-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->
                                <button type="submit"
                                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold border border-transparent bg-primary-0 text-white hover:bg-lightPrimary-0 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Reset</button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>
