<?php

namespace App\Tests\Controller\Article;

use App\Tests\AbstractTestCase;

class PostControllerTest extends AbstractTestCase
{
    public function testCreateArticle(): void
    {
        $this->client->request('POST', '/api/v1/doc/article', [
            'title' => 'Test article',
        ]);

        $responseContent = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['id', 'title'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'title' => ['type' => 'string'],
            ],
        ]);
    }
}
