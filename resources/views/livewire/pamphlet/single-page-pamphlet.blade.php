<div class="min-h-screen bg-gray-100 py-12 font-vazir" dir="rtl">
    <x-slot name="header">
        <div class="fixed top-0 left-0 w-full bg-white shadow-md z-10">
            <div class="flex items-center justify-center w-full py-4">
                <img src="{{ asset('images/khodnevis-bg.png') }}" alt="Logo" class="h-14 text-bold">
                <div class="absolute left-14 top-6">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="font-vazir inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                
                                <div class="ms-1">
                                    <svg class="font-vazir fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 111.414 1.414l-4 4a1 1 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')" wire:navigate class="font-vazir">
                                {{ __('پروفایل') }}
                            </x-dropdown-link>
                
                            <button wire:click="logout" class="w-full text-start">
                                <x-dropdown-link class="font-vazir">
                                    {{ __('خروج') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                </div>                
            </div>
        </div>
    </x-slot>
    
    <div class="container mx-auto px-6 sm:px-8 lg:px-16">
        <div class="flex gap-8">
            <div class="w-full lg:w-2/3 bg-white shadow-lg rounded-lg p-8 overflow-y-auto" style="max-height: 80vh;">
                @if ($showForm)
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-700">صدای خود را به جزوه تبدیل کنید</h3>
                        <p class="text-gray-500 mt-2">
                            فایل صوتی خود را بارگذاری کنید و دستورالعمل‌های دلخواه خود را وارد کنید.
                        </p>
                    </div>

                    <div class="mt-8">
                        <div class="mb-6">
                            <x-input-label for="audioFile" :value="'انتخاب فایل صوتی'" />
                            <x-text-input wire:model="audioFile" id="audioFile" name="audioFile" type="file"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-right" />
                            <x-input-error :messages="$errors->get('audioFile')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="customPrompt" :value="'دستورالعمل‌های دلخواه (اختیاری)'" />
                            <textarea wire:model="customPrompt" id="customPrompt" name="customPrompt"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-right"
                                rows="4" placeholder="دستورالعمل‌های دلخواه خود را وارد کنید..."></textarea>
                            <x-input-error :messages="$errors->get('customPrompt')" class="mt-2" />
                        </div>

                        <div wire:loading class="text-center loading-state text-blue-600 font-semibold">
                            در حال پردازش درخواست شما...
                        </div>

                        <div class="text-center">
                            <button wire:click="transcribeAndGenerate"
                                class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition ease-in-out duration-150">
                                ایجاد جزوه
                            </button>
                        </div>
                    </div>
                @else
                    <div class="mt-4">
                        <button wire:click="goBackToForm" class="px-4 py-2 bg-gray-500 text-white rounded-md">
                            بازگشت به فرم
                        </button>

                        @if ($selectedPamphlet)
                            <h3 class="text-xl font-bold mt-4">{{ $selectedPamphlet->title }}</h3>
                            <p class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($selectedPamphlet->created_at)->locale('fa')->diffForHumans() }}</p>
                            <div class="mt-2 prose text-right">
                                {!! $selectedPamphlet->html_content !!}
                            </div>

                            <div class="mt-4 text-right">
                                <button wire:click="deletePamphlet({{ $selectedPamphlet->id }})"
                                    class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition ease-in-out duration-150">
                                    حذف جزوه
                                </button>
                            </div>
                        @else
                            <p class="text-gray-500 mt-8">لطفاً جزوه‌ای را انتخاب کنید</p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="w-full lg:w-1/3 bg-white shadow-lg rounded-lg p-8 overflow-y-auto" style="max-height: 80vh;">
                <h3 class="text-xl font-bold text-gray-700">تاریخچه جزوات</h3>
                <div class="mt-4 space-y-4">
                    @foreach ($pamphlets as $pamphlet)
                        <div class="p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100"
                            wire:click="showPamphlet({{ $pamphlet->id }})">
                            <h4 class="text-lg font-semibold text-gray-700">{{ $pamphlet->title }}</h4>
                            <p class="text-gray-500 text-sm">{{ Str::limit(strip_tags($pamphlet->html_content), 100) }}</p>
                            <p class="text-gray-400 text-xs mt-2">{{ \Carbon\Carbon::parse($pamphlet->created_at)->locale('fa')->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
