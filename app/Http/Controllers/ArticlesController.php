<?php

namespace App\Http\Controllers;

use App\Models\Models\Article;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    public function index()
    {
        $count = 20;

        try {
            $client = new Client();
            $apiRequest = $client->request('GET','https://newsapi.org/v2/top-headlines?country=jp&category=business&pageSize='.$count.'&apiKey='); //APIキー追加
            $response = json_decode($apiRequest->getBody()->getContents(), true);
            
            $apiRequest2 = $client->request('GET','https://newsapi.org/v2/top-headlines?country=jp&category=technology&pageSize='.$count.'&apiKey=');　//APIキー追加
            $response2 = json_decode($apiRequest2->getBody()->getContents(), true);

            $bz_news = [];
            $tc_news = [];
            // ビジネスニュース
            for ($idx = 0; $idx < $count; $idx++) {
                array_push($bz_news, [
                    'title' => $response['articles'][$idx]['title'],
                    'url' => $response['articles'][$idx]['url'],
                    'thumbnail' => $response['articles'][$idx]['urlToImage'],
                    'published' => $response['articles'][$idx]['publishedAt'],
                ]);
            }

            // テクノロジーニュース
            for ($idx = 0; $idx < $count; $idx++) {
                array_push($tc_news, [
                    'title' => $response2['articles'][$idx]['title'],
                    'url' => $response2['articles'][$idx]['url'],
                    'thumbnail' => $response2['articles'][$idx]['urlToImage'],
                    'published' => $response2['articles'][$idx]['publishedAt'],
                ]);
            }
        } catch (RequestException $e) {
            //For handling exception
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        return view('index', compact('bz_news', 'tc_news'));
    }

    public function save(Request $request) {
        $inputs = $request->all();

        DB::beginTransaction();

        try {
            Article::create($inputs);
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollBack();
            abort(500);
        }

        return redirect('/');
    }

    public function show() {
        $user = \Auth::user();
        if($user) {
            $articles = Article::all();
    
            $tags = Article::all()
                    ->groupBy('tag');
    
            return view('show', compact('articles','tags'));
        }else {
            return redirect('/');
        }
    }

    public function update(Request $request) {
        $inputs = $request->all();

        DB::beginTransaction();

        try {
            $article = Article::find($inputs['id']);
            $article->fill([
                'tag' => $inputs['tag']
            ]);
            $article->save();
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollBack();
            abort(500);
        }

        return redirect('/show');
    }

    public function sortByTag(Request $request ,$id) {

        $user = \Auth::user();
        if($user) {
            $articles = Article::where('tag', $id)
                        ->get();
            
            $tags = Article::all()
            ->groupBy('tag');
        
            return view('tag', compact('articles','tags'));
        }else {
            return redirect('/');
        }
    }

    public function search(Request $request) {
        $keyword = $request->input('keyword');

        $count = 20;

        try {
            $client = new Client();
            $apiRequest = $client->request('GET','https://newsapi.org/v2/top-headlines?q='.$keyword.'&sortBy=relevancy&pageSize='.$count.'&apiKey=');　//APIキー追加
            $response = json_decode($apiRequest->getBody()->getContents(), true);
            $bz_news = [];



            if($response['totalResults'] < $count) { 
                for ($idx = 0; $idx < $response['totalResults']; $idx++) {
                    array_push($bz_news, [
                        'title' => $response['articles'][$idx]['title'],
                        'url' => $response['articles'][$idx]['url'],
                        'thumbnail' => $response['articles'][$idx]['urlToImage'],
                        'published' => $response['articles'][$idx]['publishedAt'],
                    ]);
                }
            }else {
                for ($idx = 0; $idx < $count; $idx++) {
                    array_push($bz_news, [
                        'title' => $response['articles'][$idx]['title'],
                        'url' => $response['articles'][$idx]['url'],
                        'thumbnail' => $response['articles'][$idx]['urlToImage'],
                        'published' => $response['articles'][$idx]['publishedAt'],
                    ]);
                }
            }
            
        } catch (RequestException $e) {
            //For handling exception
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        return view('search_result', compact('bz_news','keyword'));
    }
}
