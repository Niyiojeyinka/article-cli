<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\ThirdParties\Articles\DevTo;
use Illuminate\Support\Facades\Http;

class DevToTest extends TestCase
{
    private $provider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->provider = new DevTo();
        Http::preventStrayRequests();

    }

    public function testFetchArticles()
    {
        Http::fake([
            config('services.devto.base_url')."/*" => Http::response($this->getSampleApiResponse(), 200),
        ]);

        $fetchResponse = $this->provider->fetchArticles(5);

        $this->assertIsArray($fetchResponse);
        $this->assertNotEmpty($fetchResponse);
        $this->assertArrayHasKey('success', $fetchResponse);
        $this->assertArrayHasKey('data', $fetchResponse);
        $this->assertEquals(true, $fetchResponse['success']);
        $this->assertIsArray($fetchResponse['data']);

        foreach ($fetchResponse['data'] as $article) {
            $this->assertArrayHasKey('title', $article);
            $this->assertArrayHasKey('publish_date', $article);
            $this->assertArrayHasKey('comments_count', $article);
            $this->assertArrayHasKey('author', $article);
        }
    }

    public function testFetchArticlesWithCommentsOnly()
    {
        Http::fake([
            config('services.devto.base_url')."/*" => Http::response($this->getSampleApiResponseWithComments(), 200),
        ]);

        $fetchResponse = $this->provider->fetchArticles(5, true);

        $this->assertIsArray($fetchResponse);
        $this->assertNotEmpty($fetchResponse);
        $this->assertArrayHasKey('success', $fetchResponse);
        $this->assertArrayHasKey('data', $fetchResponse);
        $this->assertEquals(true, $fetchResponse['success']);
        $this->assertIsArray($fetchResponse['data']);

        foreach ($fetchResponse['data'] as $article) {
            $this->assertGreaterThan(0, $article['comments_count']);
        }
    }
}
