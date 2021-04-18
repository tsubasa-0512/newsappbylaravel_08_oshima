@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 pt-16">
    <div class="latest-business-news">
        <h2 class="uppercase tracking-wider text-white-500 text-lg font-semibold">ビジネス</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
        @foreach($bz_news as $data)
            <div class="mt-8">
                <a href="{{$data['url']}}" target="_blank" rel="noopener noreferrer">
                    <img src="{{$data['thumbnail']}}" alt="" class="object-cover h-56 w-full hover:opacity-75 transition
                     ease-in-out duration-150">
                </a>
                <div class="mt-2">
                    <a href="{{$data['url']}}" class="text-lg mt-2 hover:text-gray-300">{{$data['title']}}</a>
                    <div class="flex items-center text-gray-400 text-sm mt-1">
                        <span>{{$data['published']}}</span>
                    </div>
                    @auth
                    <div class="flex items-center text-gray-400 text-sm mt-2">
                        <form method="POST" action="/save">
                        @csrf
                            <input type="hidden" name="url" value="{{$data['url']}}"/>
                            <input type="hidden" name="thumbnail" value="{{$data['thumbnail']}}"/>
                            <input type="hidden" name="title" value="{{$data['title']}}"/>
                            <input type="hidden" name="published" value="{{$data['published']}}"/>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}"/>
                            <input type="text" name="tag" placeholder="タグ" class="pl-1 h-6"/>
                            <input type="submit" value="Pick" class="bg-purple-500 text-gray-900 rounded font-semibold px-3 py-1
                            hover:bg-purple-600 transition ease-in-out duration-150 cursor-pointer">
                        </form>
                    </div>
                    @endauth
                </div>
            </div>
        @endforeach
        </div>
    </div>
    <div class="latest-technology-news py-24">
        <h2 class="uppercase tracking-wider text-white-500 text-lg font-semibold">テクノロジー</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
        @foreach($tc_news as $data)
        <div class="mt-8">
                <a href="{{$data['url']}}" target="_blank" rel="noopener noreferrer">
                    <img src="{{$data['thumbnail']}}" alt="" class="object-cover h-56 w-full hover:opacity-75 transition
                     ease-in-out duration-150">
                </a>
                <div class="mt-2">
                    <a href="{{$data['url']}}" class="text-lg mt-2 hover:text-gray-300">{{$data['title']}}</a>
                    <div class="flex items-center text-gray-400 text-sm mt-1">
                        <span>{{$data['published']}}</span>
                    </div>
                    @auth
                    <div class="flex items-center text-gray-400 text-sm mt-2">
                        <form method="POST" action="/save">
                        @csrf
                            <input type="hidden" name="url" value="{{$data['url']}}"/>
                            <input type="hidden" name="thumbnail" value="{{$data['thumbnail']}}"/>
                            <input type="hidden" name="title" value="{{$data['title']}}"/>
                            <input type="hidden" name="published" value="{{$data['published']}}"/>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}"/>
                            <input type="text" name="tag" placeholder="タグ" class="pl-1 h-6"/>
                            <input type="submit" value="Pick" class="bg-purple-500 text-gray-900 rounded font-semibold px-3 py-1
                            hover:bg-purple-600 transition ease-in-out duration-150 cursor-pointer">
                        </form>
                    </div>
                    @endauth
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
@endsection