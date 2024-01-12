<?php

namespace App\Providers;

use App\ThirdParties\Articles\ArticleProviderInterface;
use App\ThirdParties\Articles\DevTo;
use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    private $activeProvider;
    private $providers = [
        'devto' => DevTo::class,
    ];

    public function __construct($app)
    {
        parent::__construct($app);
        $this->activeProvider = config('app.active_article_provider');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ArticleProviderInterface::class, function ($app) {
            return new $this->providers[$this->activeProvider];
        });
    }


    public function boot(): void
    {
        //
    }
}
