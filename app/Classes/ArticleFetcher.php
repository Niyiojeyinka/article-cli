<?php

namespace App\Classes;

use App\ThirdParties\Articles\ArticleProviderInterface;

class ArticleFetcher
{
    protected $provider;

    public function __construct(ArticleProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function setProvider(ArticleProviderInterface $provider = null)
    {   if ($provider === null) {
            $provider = app()->make(ArticleProviderInterface::class);
        }

        $this->provider = $provider;
    }

    public function fetchArticles($limit = 5, $hasCommentsOnly = false)
    {
        return $this->provider->fetchArticles($limit, $hasCommentsOnly);
    }
}
