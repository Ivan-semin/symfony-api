<?php

namespace App\Tests\Controller\Tag;

use App\Tests\AbstractTestCase;

class PostControllerTest extends AbstractTestCase
{
    public function testCreateTag(): void
    {
        $this->client->request('POST', '/api/v1/doc/tag', [
            'name' => 'Test tag',
        ]);

        $responseContent = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['id', 'name'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'name' => ['type' => 'string'],
            ],
        ]);
    }
}
