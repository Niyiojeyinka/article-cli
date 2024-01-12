<?php
namespace App\ThirdParties\Articles;

interface ArticleProviderInterface
{
    public const TIMEOUT_IN_SECONDS = 10;
    /**
     * Fetch articles from the provider.
     * @param int $limit
     * @param bool $hasCommentsOnly
     * @return array of articles [ ['title' => '...', 'publish_date' => '...', 'comments_count' => '...', 'author' => '...'], ... ]
    */
    public function fetchArticles($limit = 5, $hasCommentsOnly = false) : array;
}
