<?php

namespace Tests\Unit;

use App\ThirdParties\Articles\ArticleProviderInterface;
use Mockery;
use Tests\TestCase;


class ArticleFetcherTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
    public function testFetchArticles()
    {

        $providerMock = Mockery::mock(ArticleProviderInterface::class);
        $providerMock->shouldReceive('fetchArticles')->once()->andReturn([
            'success' => true,
            'data' => [
                [
                    'title' => 'Test Title',
                    'publish_date' => '2020-01-01',
                    'comments_count' => 5,
                    'author' => 'Test Author',
                ],
            ],
        ]);

        $fetchResponse = $providerMock->fetchArticles(5);

        $this->assertIsArray($fetchResponse);
        $this->assertNotEmpty($fetchResponse);

    }
}
