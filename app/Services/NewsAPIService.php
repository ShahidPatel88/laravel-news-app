<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsAPIService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('NEWS_API_KEY');
    }

    public function getArticles($request)
    {
        
        
        $url = 'https://newsapi.org/v2/everything';
    
        
        $params = [
            'apiKey' => $this->apiKey,
            'q' => 'all',
        ];

        if (isset($request['keyword']) && $request['keyword'] != null) {
            $params['q'] = $request['keyword'];
        }

        if(isset($request['publishedAt']) && $request['publishedAt'] != null){
            $params['from'] = $request['publishedAt'];
            $params['to'] = $request['publishedAt'];
        }
        
        $response = Http::get($url, $params);
        
        if ($response->successful()) {
            // NewsModel::storeRecords($response->json()['articles']);
            return $response->json()['articles'];
        }

        return null;
    }
}
