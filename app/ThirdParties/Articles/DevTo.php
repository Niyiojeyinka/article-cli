<?php


namespace App\ThirdParties\Articles;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DevTo implements ArticleProviderInterface
{
    public $baseUrl;

    public function __construct() {
        $this->baseUrl = config('services.devto.base_url');
    }

    public function fetchArticles($limit = 5, $hasCommentsOnly = false): array
    {
        try{
            $response = Http::timeout(self::TIMEOUT_IN_SECONDS)->get($this->baseUrl . '/articles', [
                'per_page' => $limit,
            ]);

            $articles = $response->json();

            if ($hasCommentsOnly) {
                $articles = array_filter($articles, function ($article) {
                    return $article['comments_count'] > 0;
                });
            }

            $articles = array_map(function ($article) {
               return [
                    'title' => $article['title'],
                    'publish_date' => $article['readable_publish_date'],
                    'comments_count' => $article['comments_count'],
                    'author' => $article['user']['username'],
               ];
            }, $articles);

            return [
                'success' => true,
                'data' => $articles,
            ];
        }catch(\Exception $e){
            Log::error($e->getMessage());

            return [
                'success' => false,
                'message' => 'Something went wrong. Please try again later.',
                'data' => [],
            ];
        }
    }
}
