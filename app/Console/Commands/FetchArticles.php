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

        /**
         * active provider is set in config/app.php/.env file, this is just an example
         * can also be override on the fly by calling setProvider() method
         * $articleFetcher->setProvider($provider);
         **/

        $fetchResponse = $articleFetcher->fetchArticles($limit, $hasCommentsOnly);
        if (!$fetchResponse['success']) {
            $this->error($fetchResponse['message']);
            return;
        }

        if (empty($articles = $fetchResponse['data'])){
            $this->info('No articles found.');
            return;
        }

        $headers = ['Title', 'Publish Date', 'Comments Count', 'Author'];

        $this->table($headers, $articles);
    }
}
