<?php


namespace App\ThirdParties\Articles;

use Illuminate\Support\Facades\Http;

class DevTo implements ArticleProviderInterface
{
    public $baseUrl;

    public function __construct() {
        $this->baseUrl = config('services.devto.base_url');
    }

    /**
     * Fetch articles from the provider.
     * @param int $limit
     * @param bool $hasCommentsOnly
     * @return array of articles [ ['title' => '...', 'publish_date' => '...', 'comments_count' => '...', 'author' => '...'], ... ]
    */
    public function fetchArticles($limit = 5, $hasCommentsOnly = false): array
    {
        $response = Http::timeout(self::TIMEOUT_IN_SECONDS)->get($this->baseUrl . '/articles', [
            'per_page' => $limit,
        ]);

        $articles = $response->json();

        if ($hasCommentsOnly) {
            $articles = array_filter($articles, function ($article) {
                return $article['comments_count'] > 0;
            });
        }

        return array_map(function ($article) {
            return [
                'title' => $article['title'],
                'publish_date' => $article['readable_publish_date'],
                'comments_count' => $article['comments_count'],
                'author' => $article['user']['username'],
            ];
        }, $articles);
    }
}
