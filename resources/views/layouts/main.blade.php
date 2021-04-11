<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>News App</title>
</head>
<body class="font-sans bg-gray-900 text-white">
    <nav class="border-b border-gray-800">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between px-4 py-6">
        <ul class="flex flex-col md:flex-row items-center">
            <li class="mt-3 md:mt-8">
                <a href="/" class="uppercase font-bold text-2xl text-white-500">NewsApp</a>
            </li>
            @auth
            <li class="md:ml-16 mt-3 md:mt-8">
                <a href="../show" class="hover::text-gray-300">Pickした記事一覧</a>
            </li>
            @endauth
        </ul>
        <div class="flex flex-col md:flex-row items-center">
            <div class="relative mt-3 md:mt-8">
                <input type="text" class="bg-gray-800 rounded-full w-64 px-4 pl-8 py-1
                focus:outline-none focus:shadow-outline" placeholder="キーワードで検索">
                <div class="absolute top-0">
                    <svg class="ml-2 mt-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
            </div>
            <div class="md:ml-4 mt-3 md:mt-8">
                @if (Route::has('login'))
                <div class="px-6 py-4 sm:block">
                    @auth
                        @if (Auth::user()->profile_photo_url)
                        <a href="{{ url('/user/profile') }}" class="hover::text-gray-300">
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </a>
                        @else
                        <a href="{{ url('/user/profile') }}" class="hover::text-gray-300">
                            <img class="h-8 w-8 rounded-full object-cover" src="" alt="{{ Auth::user()->name }}" />
                        </a>
                        @endif
                    @else   
                        <a href="{{ route('login') }}" class="hover::text-gray-300">ログイン</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 hover::text-gray-300">アカウント作成</a>
                        @endif
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
    </nav>
    @yield('content')
</body>
</html>