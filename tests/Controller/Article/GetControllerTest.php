<?php

namespace App\Tests\Controller\Article;

use App\Entity\Article;
use App\Tests\AbstractTestCase;

class GetControllerTest extends AbstractTestCase
{
    public function testGetArticles(): void
    {
        $article = (new Article())
            ->setTitle('Test');

        $this->setEntityId($article, 1);

        $this->em->persist($article);

        $this->client->request('GET', '/api/v1/doc/articles');

        $responseContent = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertResponseIsSuccessful();

        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'title'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'title' => ['type' => 'string'],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
