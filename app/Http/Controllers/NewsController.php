<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NewsAPIService;
use DataTables;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsAPIService $newsService)
    {
        $this->newsService = $newsService;
    }
    
    public function index(Request $request)
    {
        return view('news.index');
    }

    public function getArticles(Request $request){
        $articles = $this->newsService->getArticles($request->all());
        
        if ($articles !== null) {
            if (isset($request->title)) {
                $articles = array_filter($articles, function($article) use ($request) {
                    return stripos($article['title'], $request->title) !== false;
                });
            }
    
            if (isset($request->source)) {
                
                $articles = array_filter($articles, function($article) use ($request) {
                    return stripos($article['source']['name'], $request->source) !== false;
                });
            }
        
            if (isset($request->publishedAt)) {
                $articles = array_filter($articles, function($article) use ($request) {
                    return strpos($article['publishedAt'], $request->publishedAt) !== false;
                });
            }
    
            if (isset($request->author)) {
                $articles = array_filter($articles, function($article) use ($request) {
                    return stripos($article['author'], $request->author) !== false;
                });
            }
        }
        
        return Datatables::of($articles)
        ->addColumn('title', function ($article) {
            return $article['title'] ?? '-';
        })
        ->addColumn('source', function ($article) {
            return $article['source']['name'] ?? '-';
        })
        ->addColumn('published_at', function ($article) {
            return $article['publishedAt'] ?? '-';
        })
        ->addColumn('author', function ($article) {
            return $article['author'] ?? '-';
        })
        ->addColumn('description', function ($article) {
            return $article['description'] ?? '-';
        })
        ->make(true);
    }
}
