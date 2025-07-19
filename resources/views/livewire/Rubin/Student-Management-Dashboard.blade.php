<div class="flex min-h-screen font-dana rtl bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-[#2a68b2] p-4 flex flex-col space-y-4 shadow-2xl">
        <h1 class="text-xl font-bold text-white mb-4">منو</h1>
        
        <button wire:click="toggleStudentList" class="flex items-center justify-between w-full p-3 bg-white text-[#2a68b2] hover:bg-[#1e4e8c] hover:text-white font-medium rounded-lg transition duration-200">
            <span>لیست دانشجویان</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path>
            </svg>
        </button>
        
        <button wire:click="toggleGlobalChat" class="flex items-center justify-between w-full p-3 bg-white text-[#2a68b2] hover:bg-[#1e4e8c] hover:text-white font-medium rounded-lg transition duration-200">
            <span>چت عمومی</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
        </button>
        
        <button wire:click="toggleLabels" class="flex items-center justify-between w-full p-3 bg-white text-[#2a68b2] hover:bg-[#1e4e8c] hover:text-white font-medium rounded-lg transition duration-200">
            <span>دسته‌بندی‌ها</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10M7 15h10"></path>
            </svg>
        </button>
        
        <a href="{{ route('students.dashboard') }}" class="flex items-center justify-between w-full p-3 bg-white text-[#2a68b2] hover:bg-[#1e4e8c] hover:text-white font-medium rounded-lg transition duration-200">
            <span>بارگذاری لیست جدید</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
            </svg>
        </a>
        
        <div x-data="{ open: false }" class="relative mt-8">
            <button @click="open = !open" class="w-full flex items-center justify-between p-3 text-white bg-[#1e4e8c] hover:bg-[#1b4379] rounded-lg transition duration-200">
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
        <div class="max-w-6xl mx-auto space-y-6">
            @if ($showLabelsView)
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h1 class="text-xl font-bold text-gray-800 mb-5">برچسب‌ها</h1>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach ($labels as $label)
                            <button wire:click="showStudentsForLabel({{ $label->id }})" class="w-full p-4 bg-white rounded-lg border border-gray-200 hover:border-[#2a68b2] transition flex items-center justify-between">
                                <p class="font-medium text-gray-700">{{ $label->name }}</p>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($studentsForLabel && $currentLabel)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-700 bg-opacity-50">
                    <div class="bg-white p-5 rounded-xl shadow-lg w-full sm:w-1/2 max-h-[80vh] overflow-y-auto">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-bold text-gray-800">دانشجویان برچسب "{{ $currentLabel->name }}"</h2>
                            <button wire:click="toggleLabels" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <ul class="divide-y divide-gray-200">
                            @foreach ($studentsForLabel as $student)
                                <li class="py-3 flex justify-between items-center">
                                    <span class="text-gray-700">{{ $student->first_name }} {{ $student->last_name }}</span>
                                    <span class="text-xs text-gray-500">{{ $student->registration_status ? 'فعال' : 'غیرفعال' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if ($showStudentList)
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h1 class="text-xl font-bold text-gray-800 mb-5">لیست دانشجویان</h1>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach ($students as $student)
                            <button wire:click="showStudent('{{ $student->id }}')" class="w-full p-3 bg-white rounded-lg border hover:border-[#2a68b2] transition {{ $selectedStudent && $selectedStudent->id === $student->id ? 'border-2 border-[#2a68b2]' : 'border-gray-200' }}">
                                <p class="font-medium text-[#2a68b2]">{{ $student->first_name }} {{ $student->last_name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $student->registration_status ? 'فعال' : 'غیرفعال' }}</p>
                            </button>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $students->links() }}
                    </div>
                </div>
            @endif

            @if ($showStudentDetails && $selectedStudent)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-[#2a68b2] text-white p-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold">اطلاعات کامل: {{ $selectedStudent->first_name }} {{ $selectedStudent->last_name }}</h3>
                        <div class="flex space-x-2">
                            <button wire:click="toggleStudentList" class="p-2 text-white hover:bg-[#1e4e8c] rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                            </button>
                            <button wire:click="toggleEditMode" class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 text-sm">
                                {{ $editMode ? 'لغو ویرایش' : 'ویرایش' }}
                            </button>
                        </div>
                    </div>

                    @if (session()->has('message'))
                        <div class="bg-green-100 text-green-700 p-3 text-sm">
                            <p>{{ session('message') }}</p>
                        </div>
                    @endif

                    <div class="p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">نام:</label>
                                    @if ($editMode)
                                        <input type="text" wire:model="editableStudent.first_name" class="w-full p-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2a68b2] focus:border-transparent">
                                    @else
                                        <p class="p-2 bg-gray-50 rounded text-sm">{{ $selectedStudent->first_name }}</p>
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">اطلاعات تماس:</label>
                                    @if ($editMode)
                                        <input type="text" wire:model="editableStudent.contact_info" class="w-full p-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2a68b2] focus:border-transparent">
                                    @else
                                        <p class="p-2 bg-gray-50 rounded text-sm">{{ $selectedStudent->contact_info }}</p>
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">وضعیت ثبت‌نام:</label>
                                    @if ($editMode)
                                        <select wire:model="editableStudent.registration_status" class="w-full p-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2a68b2] focus:border-transparent">
                                            <option value="1">فعال</option>
                                            <option value="0">غیرفعال</option>
                                        </select>
                                    @else
                                        <p class="p-2 bg-gray-50 rounded text-sm">{{ $selectedStudent->registration_status ? 'فعال' : 'غیرفعال' }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">نام خانوادگی:</label>
                                    @if ($editMode)
                                        <input type="text" wire:model="editableStudent.last_name" class="w-full p-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2a68b2] focus:border-transparent">
                                    @else
                                        <p class="p-2 bg-gray-50 rounded text-sm">{{ $selectedStudent->last_name }}</p>
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">مهارت‌ها و علاقه‌مندی‌ها:</label>
                                    @if ($editMode)
                                        <textarea wire:model="editableStudent.skills_interests" class="w-full p-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2a68b2] focus:border-transparent" rows="3"></textarea>
                                    @else
                                        <p class="p-2 bg-gray-50 rounded text-sm">{{ $selectedStudent->skills_interests }}</p>
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">یادداشت‌ها:</label>
                                    @if ($editMode)
                                        <textarea wire:model="editableStudent.comments_notes" class="w-full p-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2a68b2] focus:border-transparent" rows="3"></textarea>
                                    @else
                                        <p class="p-2 bg-gray-50 rounded text-sm">{{ $selectedStudent->comments_notes }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if ($editMode)
                            <div class="mt-5 flex justify-end space-x-2">
                                <button wire:click="toggleEditMode" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm">انصراف</button>
                                <button wire:click="saveStudentChanges" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 text-sm">ذخیره تغییرات</button>
                            </div>
                        @endif
                    </div>

                    <div class="border-t border-gray-200 p-4 bg-gray-50">
                        <h4 class="text-base font-medium text-gray-800 mb-3">مکالمه با دانشجو</h4>
                        <div class="space-y-3 max-h-48 overflow-y-auto p-2">
                            @foreach ($messages as $message)
                                <div class="flex {{ $message['user'] ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-xs md:max-w-md rounded-lg p-3 text-sm {{ $message['user'] ? 'bg-[#2a68b2] text-white' : 'bg-gray-200 text-gray-800' }}">
                                        <p class="whitespace-pre-wrap">{{ $message['message'] }}</p>
                                        <p class="text-xs mt-1 {{ $message['user'] ? 'text-blue-100' : 'text-gray-500' }}">{{ $message['user'] ? 'شما' : 'روبین' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3 flex items-center">
                            <input type="text" wire:model="userMessage" placeholder="پیام خود را بنویسید..." 
                                   class="flex-1 p-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2a68b2] focus:border-transparent" 
                                   wire:keydown.enter="sendMessage">
                            <button wire:click="sendMessage" class="mr-2 px-3 py-2 bg-[#2a68b2] text-white rounded-md hover:bg-[#1e4e8c]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if ($showGlobalChat)
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-800">چت عمومی</h2>
                        <button wire:click="toggleGlobalChat" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-3 max-h-96 overflow-y-auto p-2">
                        @foreach ($globalMessages as $message)
                            <div class="flex {{ $message['user'] ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-xs md:max-w-md rounded-lg p-3 text-sm {{ $message['user'] ? 'bg-[#2a68b2] text-white' : 'bg-gray-200 text-gray-800' }}">
                                    <p class="whitespace-pre-wrap">{{ $message['message'] }}</p>
                                    <p class="text-xs mt-1 {{ $message['user'] ? 'text-blue-100' : 'text-gray-500' }}">{{ $message['user'] ? 'شما' : 'روبین' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4">
                        <div class="flex items-center">
                            <input type="text" wire:model="globalUserMessage" 
                                   placeholder="پیام خود را بنویسید..."
                                   class="flex-1 p-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2a68b2] focus:border-transparent"
                                   wire:keydown.enter="sendGlobalMessage">
                            <button wire:click="sendGlobalMessage" class="mr-2 px-3 py-2 bg-[#2a68b2] text-white rounded-md hover:bg-[#1e4e8c]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>