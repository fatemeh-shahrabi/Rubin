<div x-data="{ show: true }" class="font-dana rtl min-h-screen bg-gray-100">
    @if (auth()->user()->role === 'Manager')
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <div class="w-64 bg-[#2a68b2] p-4 flex flex-col space-y-4 shadow-2xl">
                <h1 class="text-xl font-bold text-white mb-4">منو</h1>
                
                <a href="{{ route('students.import') }}" class="flex items-center justify-between w-full p-3 bg-white text-[#2a68b2] hover:bg-[#1e4e8c] hover:text-white font-medium rounded-lg transition duration-200" aria-label="مشاهده لیست دانشجویان">
                    <span>لیست دانشجویان</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </a>
                
                <div x-data="{ open: false }" class="relative mt-8">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-3 text-white bg-[#1e4e8c] hover:bg-[#1b4379] rounded-lg transition duration-200" aria-label="منوی پروفایل">
                        <span class="font-medium">پروفایل</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform" :class="open ? 'rotate-180' : 'rotate-0'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-1 w-full bg-white rounded-lg shadow-lg overflow-hidden z-50" x-cloak>
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">پروفایل</a>
                        <button wire:click="logout" class="w-full text-right px-4 py-2 text-red-600 hover:bg-red-100 transition">خروج از حساب</button>
                    </div>
                </div>
                
                <div class="mt-auto pt-4 text-center border-t border-[#3a78c2]">
                    <p class="text-sm text-white">خوش آمدی <span x-data="{ name: '{{ auth()->user()->name }}' }" x-text="name" class="font-medium"></span></p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 p-4 overflow-auto">
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <h1 class="text-xl font-bold text-gray-800 mb-5">بارگذاری فایل CSV</h1>
                        <form wire:submit.prevent="uploadcsv" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">فایل CSV</label>
                                <input type="file" wire:model="csvfile" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2a68b2] transition" aria-label="انتخاب فایل CSV">
                                @error('csvfile') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="w-full bg-[#2a68b2] text-white font-medium py-2.5 px-4 rounded-lg hover:bg-[#1e4e8c] transition duration-200 flex items-center justify-center" aria-label="بارگذاری فایل">
                                <span wire:loading.remove>بارگذاری فایل</span>
                                <span wire:loading>
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    در حال بارگذاری...
                                </span>
                            </button>
                        </form>

                        @if (session()->has('success'))
                            <div class="mt-4 p-3 bg-green-100 text-green-700 rounded-lg relative animate-fade-in-out" x-show="show" x-transition>
                                <div class="flex justify-between items-center">
                                    <span>{{ session('success') }}</span>
                                    <button @click="show = false" class="text-green-700 hover:text-green-900" aria-label="بستن پیام">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($csvData && count($csvData) > 0)
                        <div class="bg-white rounded-xl shadow-sm p-5">
                            <div class="flex justify-between items-center mb-4">
                                <h1 class="text-lg font-bold text-gray-800">پیش‌نمایش داده‌های CSV</h1>
                                <button wire:click="clearPreview" class="text-sm text-red-600 hover:text-red-800" aria-label="پاک کردن پیش‌نمایش">
                                    پاک کردن پیش‌نمایش
                                </button>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm border-collapse">
                                    <thead class="bg-[#2a68b2] text-white">
                                        <tr>
                                            @foreach ($headers as $header)
                                                <th class="px-3 py-2.5 text-right font-medium">{{ $header }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($csvData as $index => $row)
                                            <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-blue-50 transition">
                                                @foreach ($row as $cell)
                                                    <td class="px-3 py-2.5 text-right">{{ $cell }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="flex h-screen items-center justify-center bg-gray-100">
            <div class="p-6 max-w-md bg-white rounded-xl shadow-md text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-gray-800 mb-2">دسترسی غیرمجاز!</h1>
                <p class="text-gray-600">شما مجوز دسترسی به این بخش را ندارید.</p>
                <a href="{{ route('students.import') }}" class="mt-4 inline-block px-4 py-2 bg-[#2a68b2] text-white rounded-lg hover:bg-[#1e4e8c] transition" aria-label="بازگشت به صفحه اصلی">
                    بازگشت به صفحه اصلی
                </a>
            </div>
        </div>
    @endif
</div>