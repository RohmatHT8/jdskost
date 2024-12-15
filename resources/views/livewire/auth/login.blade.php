<section class="flex justify-center items-center h-screen bg-gradient-to-tr from-gray-50 to-gray-100">
    <div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="flex h-full items-center">
            <main class="w-full max-w-md mx-auto p-6">
                <div class="bg-white border border-gray-200 shadow-lgz">
                    <div class="p-4 sm:p-7">
                        <div class="text-center">
                            <img src="{{asset('assets/logo.png')}}" class="h-10 mx-auto"  alt="logo"/>
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
                                    <label for="email" class="block text-sm mb-2 dark:text-white">Email</label>
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
                                        <label for="password"
                                            class="block text-sm mb-2 dark:text-white">Password</label>
                                        <a class="text-sm text-primary-0 hover:text-lightPrimary-0 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                            href="/forgot">Lupa Password?</a>
                                    </div>
                                    <div class="relative" x-data="{ show: false }">
                                        <input :type="show ? 'text' : 'password'" wire:model="password" id="password"
                                            name="password" class="form" placeholder="Password"
                                            aria-describedby="password-error">
                                        <button type="button" @click="show = !show"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 focus:outline-none">
                                            <svg x-show="!show" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                aria-hidden="true">
                                                <path
                                                    d="M2.94 10.05a10 10 0 0 1 14.12 0 1 1 0 0 1 0 1.41A10 10 0 0 1 2.94 10.05a1 1 0 0 1 0-1.41zM10 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zM10 7a3 3 0 1 1 0 6 3 3 0 0 1 0-6z" />
                                            </svg>
                                            <svg x-show="show" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                aria-hidden="true">
                                                <path
                                                    d="M13.3 12.7a1 1 0 0 1 0 1.4 10.7 10.7 0 0 1-6.3 2.8 1 1 0 0 1-1-1V7.4A1 1 0 0 1 7 6.4a8.5 8.5 0 0 1 6.3-2.7c.5.2.7.8.4 1.3-1.5 1.7-3 3.5-4.4 5.4a1 1 0 0 0 .3 1.4 1 1 0 0 1 .5 1z" />
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
