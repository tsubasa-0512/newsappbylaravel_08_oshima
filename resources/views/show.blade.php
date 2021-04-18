@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 pt-16">
    <div class="mypick-news flex flex-row items-center">
        <div class="news-area pr-4">
            <h2 class="uppercase tracking-wider text-white-500 text-lg font-semibold">Pickした記事一覧</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($articles as $data)
                @if((int)$data['user_id'] == Auth::id())
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
                            <div class="flex items-center text-gray-400 text-sm mt-2">
                                <form method="POST" action="/update">
                                @csrf
                                    <input type="hidden" name="id" value="{{$data['id']}}"/>
                                    <input type="hidden" name="url" value="{{$data['url']}}"/>
                                    <input type="hidden" name="thumbnail" value="{{$data['thumbnail']}}"/>
                                    <input type="hidden" name="title" value="{{$data['title']}}"/>
                                    <input type="hidden" name="published" value="{{$data['published']}}"/>
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}"/>
                                    <input type="text" name="tag" value="{{$data['tag']}}" class="pl-1 h-6"/>
                                    <input type="submit" value="Pick" class="bg-purple-500 text-gray-900 rounded font-semibold px-3 py-1
                                    hover:bg-purple-600 transition ease-in-out duration-150 cursor-pointer">
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="tag-area w-2/5 mb-auto">
        <h2 class="uppercase tracking-wider text-white-500 text-lg font-semibold">タグ</h2>
        @foreach ($tags as $data)
        @if((int)$data[0]['user_id'] == Auth::id())
        <a href="/{{$data[0]['tag']}}" class="mr-2 mt-2 hover:underline">#{{$data[0]['tag']}}({{Count($data)}})</a>
        @endif
        @endforeach
    </div>
</div>
@endsection