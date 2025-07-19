<nav class="-mx-3 flex flex-1 justify-end">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="rounded-lg px-6 py-2 text-blue-700 hover:text-blue-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 transition duration-300"
        >
            داشبورد
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="rounded-lg px-6 py-2 text-blue-700 hover:text-blue-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 transition duration-300"
        >
            ورود
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="rounded-lg px-6 py-2 text-blue-700 hover:text-blue-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 transition duration-300"
            >
                عضویت
            </a>
        @endif
    @endauth
</nav>
