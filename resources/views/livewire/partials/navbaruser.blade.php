<nav class="p-5 md:px-20 lg:px-32 w-full flex justify-between bg-white fixed z-50 top-0 shadow-md">
    <div class="flex gap-3">
        <a href="/" class="font-bold text-2xl text-gray-800">JDS <span class="text-green-600">KOST</span></a>
    </div>
    <div class="flex gap-3">
        <!-- Ikon User -->
        <svg id="userIcon" class="w-6 h-6 text-gray-800 hover:text-gray-500 cursor-pointer dark:text-white"
            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
            viewBox="0 0 24 24">
            <path fill-rule="evenodd"
                d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                clip-rule="evenodd" />
        </svg>
    </div>
    <!-- Pop-Up Profil User -->
    <div id="userMenu"
        class="absolute right-0 mt-10 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50">
        <div class="p-4 text-gray-800">
            <p class="font-semibold">{{ auth()->user()->name }}</p>
            <span class="font-semibold text-xs">{{ auth()->user()->role }}</span>
            <a href="/logout"
                class="flex items-center w-full mt-4 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7" />
                </svg>
                Sign Out
            </a>
        </div>
    </div>
</nav>

<script>
    userIcon.addEventListener('click', () => {
        console.log('masuk')
        userMenu.classList.toggle('hidden');
    });
</script>
