<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    public function getSampleApiResponse()
    {
        return [
            ['title' => 'Article 1', 'readable_publish_date' => '2022-01-01', 'comments_count' => 10, 'user' => ['username' => 'user1']],
            ['title' => 'Article 2', 'readable_publish_date' => '2022-02-01', 'comments_count' => 5, 'user' => ['username' => 'user2']],
        ];
    }

    protected function getSampleApiResponseWithComments()
    {
        return [
            ['title' => 'Article with Comments', 'readable_publish_date' => '2022-03-01', 'comments_count' => 15, 'user' => ['username' => 'user3']],
            ['title' => 'Another Article with Comments', 'readable_publish_date' => '2022-04-01', 'comments_count' => 8, 'user' => ['username' => 'user4']],
        ];
    }
}
