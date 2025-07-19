<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>روبین - دستیار هوشمند مدیریت دانشجویان</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #2a68b2;
            --primary-dark: #2a68b2;
            --secondary: #f59e0b;
            --light: #f8fafc;
            --dark: #1e293b;
        }
        
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: var(--light);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        .slide-up {
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: rgba(37, 99, 235, 0.1);
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body class="antialiased text-gray-800">
    <!-- Navigation -->
    <nav class="w-full py-4 bg-white shadow-sm">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('images/rubin-logo2.png') }}" alt="rubin-logo" class="h-12">
            </div>
            @if (Route::has('login'))
                <livewire:welcome.navigation />
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg text-white">
        <div class="container mx-auto px-4 py-20 md:py-28">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0 md:pr-10 fade-in">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                        مدیریت هوشمند دانشجویان با <span class="text-amber-300">روبین</span>
                    </h1>
                    <p class="text-lg md:text-xl mb-8 leading-relaxed opacity-90">
                        پلتفرم جامع مدیریت اطلاعات دانشجویان با قابلیت‌های پیشرفته هوش مصنوعی برای سازماندهی، تحلیل و ارتباط با دانشجویان
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('students.import') }}" class="bg-white text-blue-600 hover:bg-gray-100 font-medium py-3 px-8 rounded-xl shadow-md transition duration-300 flex items-center justify-center">
                            شروع کنید
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                        <a href="#features" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 font-medium py-3 px-8 rounded-xl transition duration-300 flex items-center justify-center">
                            ویژگی‌های بیشتر
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 slide-up">
                    <img src="{{ asset('images/rubin-logo.png') }}" alt="Rubin" class="w-full max-w-lg mx-auto rounded-xl shadow-2xl border-4 border-white">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">چرا روبین؟</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    راهکار جامع مدیریت دانشجویان با کمک هوش مصنوعی
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">مدیریت اطلاعات دانشجویان</h3>
                    <p class="text-gray-600">
                        بارگذاری و سازماندهی اطلاعات دانشجویان از طریق فایل‌های CSV با رابط کاربری ساده و قدرتمند
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">چت هوشمند</h3>
                    <p class="text-gray-600">
                        گفتگوی هوشمند با دستیار مجازی برای دریافت گزارش‌ها، پاسخ به سوالات و تحلیل داده‌ها
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">دسته‌بندی پیشرفته</h3>
                    <p class="text-gray-600">
                        ایجاد برچسب‌ها و دسته‌بندی‌های هوشمند برای سازماندهی و فیلتر دانشجویان بر اساس معیارهای مختلف
                    </p>
                </div>
            </div>
        </div>
    </section>

</body>
</html>