<section class="flex justify-center items-center h-screen bg-gradient-to-tr from-gray-50 to-gray-100">
    <div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="flex h-full items-center">
            <main class="w-full max-w-md mx-auto p-6">
                <div class="bg-white border border-gray-200 shadow-lgz">
                    <div class="p-4 sm:p-7">
                        <div class="text-center">
                            <img src="{{ asset('assets/logo.png') }}" class="h-10 mx-auto" alt="logo" />
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Belum memiliki akun?
                                <a class="text-primary hover:text-lightPrimary decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                    href="/register">
                                    Daftar
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
                                    <div class="flex justify-between items-center">
                                        <label for="password" class="block text-sm mb-2">Password</label>
                                        <a class="text-sm text-primary-0 hover:text-lightPrimary-0 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                            href="/forgot">Lupa Password?</a>
                                    </div>
                                    <div class="relative" x-data="{ show: false }">
                                        <input :type="show ? 'text' : 'password'" wire:model="password" id="password"
                                            name="password" class="form" placeholder="Password"
                                            aria-describedby="password-error">
                                        <button type="button" @click="show = !show"
                                            class="absolute inset-y-0 right-0 flex items-center pr-4 w-10 text-gray-500 focus:outline-none">
                                            <svg x-show="!show" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                aria-hidden="true">
                                                <path
                                                    d="M2.94 10.05a10 10 0 0 1 14.12 0 1 1 0 0 1 0 1.41A10 10 0 0 1 2.94 10.05a1 1 0 0 1 0-1.41zM10 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zM10 7a3 3 0 1 1 0 6 3 3 0 0 1 0-6z" />
                                            </svg>
                                            <svg x-show="show" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"
                                                aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                            </svg>
                                        </button>
                                        @error('password')
                                            <div
                                                class="absolute inset-y-0 right-8 flex items-center pointer-events-none pr-3">
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
                                <button type="submit"
                                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold border border-transparent bg-primary-0 text-white hover:bg-lightPrimary-0 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Masuk</button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>
