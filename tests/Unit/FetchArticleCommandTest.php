<?php

namespace Tests\Unit;

use App\Classes\ArticleFetcher;
use App\ThirdParties\Articles\ArticleProviderInterface;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;


class FetchArticleCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
    public function testFetchArticles()
    {
        $articleFetcherMock = Mockery::mock(ArticleFetcher::class);
        $articleProviderMock = Mockery::mock(ArticleProviderInterface::class);

        $expectedArticles = [[
            'title' => 'Test Article',
            'publish_date' => '2024-01-01',
            'comments_count' => 10,
            'author' => 'Test Author',
        ]];

        $articleFetcherMock->shouldReceive('fetchArticles')->andReturn(['success' => true, 'data' => $expectedArticles]);

        $this->app->instance(ArticleFetcher::class, $articleFetcherMock);
        $this->app->instance(ArticleProviderInterface::class, $articleProviderMock);

        Artisan::call('app:fetch_articles', [
            '--limit' => 5,
            '--has_comments_only' => true,
        ]);

        $this->assertStringContainsString('Test Article', Artisan::output());
  }

  protected function tearDown(): void
  {
      parent::tearDown();
      Mockery::close();
  }
}
