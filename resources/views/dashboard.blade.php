<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 font-dana">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    شما با موفقیت وارد شدید!
                    <br>
                    در حال انتقال...
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "{{ route('students.import') }}"; // تغییر به صفحه مورد نظر
        }, 1000); // 5000 میلی‌ثانیه = 5 ثانیه
    </script>

</x-app-layout>
