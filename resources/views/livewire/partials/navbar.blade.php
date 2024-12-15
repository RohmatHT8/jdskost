<nav class="p-5 md:px-20 lg:px-32 w-full flex justify-between bg-white fixed z-50 top-0 shadow-md">
    <div class="flex gap-3 items-center">
        <a href="/"><img src="{{asset('assets/logo.png')}}" class="h-6 mx-auto"  alt="logo"/></a>
        @if (auth()->user()->role === 'admin')
            <div class="flex justify-center items-center relative text-gray-400">
                <svg class="w-4 h-4 absolute left-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>
                <input type="text"
                    class="text-xs w-60 pl-8 pr-3 py-2 border border-gray-300 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600"
                    placeholder="Search" />
            </div>
        @endif
    </div>
    <div class="flex gap-3">
        {{-- @if (auth()->user()->role === 'admin') --}}
            <svg id="filterIcon" class="w-6 h-6 text-gray-800 hover:text-gray-500 cursor-pointer dark:text-white"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                    d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
            </svg>
        {{-- @endif --}}
        <svg id="userIcon" class="w-6 h-6 text-gray-800 hover:text-gray-500 cursor-pointer dark:text-white"
            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
            viewBox="0 0 24 24">
            <path fill-rule="evenodd"
                d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                clip-rule="evenodd" />
        </svg>
    </div>
    <!-- Overlay Filter -->
    <div id="filterOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="absolute right-0 top-0 bg-white w-64 h-full p-4 shadow-lg">
            <button id="closeFilter" class="text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
            </button>
            <h2 class="text-lg font-semibold mb-4">Filter by Status</h2>
            <!-- Filter Options -->
            <div class="space-y-2">
                <label class="block text-gray-700">
                    <input type="checkbox" class="mr-2"> Paid
                </label>
                <label class="block text-gray-700">
                    <input type="checkbox" class="mr-2"> On Proccess
                </label>
                <label class="block text-gray-700">
                    <input type="checkbox" class="mr-2"> Unpaid
                </label>
                <label class="block text-gray-700">
                    <input type="checkbox" class="mr-2"> Available
                </label>
            </div>
            <button class="mt-4 w-full bg-green-600 text-white text-center py-2 rounded-md">Apply</button>
        </div>
    </div>
    <!-- User Profile Pop-Up -->
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
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10v1m0-2v4m0-4v4m0 4v4" />
                </svg>
                Sign Out
            </a>
        </div>
    </div>
</nav>
