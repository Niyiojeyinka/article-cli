<?php

namespace App\Console\Commands;

use App\Classes\ArticleFetcher;
use App\ThirdParties\Articles\ArticleProviderInterface;
use Illuminate\Console\Command;

class FetchArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch_articles
    {--limit=5 : Number of articles to fetch}
    {--has_comments_only : Fetch articles with comments only}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles from active provider';

    /**
     * Execute the console command.
     */
    public function handle(ArticleFetcher $articleFetcher, ArticleProviderInterface $provider)
    {
        $limit = $this->option('limit');
        $hasCommentsOnly = $this->option('has_comments_only');
        $articleFetcher->setProvider($provider);

        $articles = $articleFetcher->fetchArticles($limit, $hasCommentsOnly);

        if (empty($articles)) {
            $this->info('No articles found.');
            return;
        }

        $headers = ['Title', 'Publish Date', 'Comments Count', 'Author'];

        $this->table($headers, $articles);
    }
}
