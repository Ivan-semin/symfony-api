<?php

namespace App\Tests\Controller\Tag;

use App\Entity\Tag;
use App\Tests\AbstractTestCase;

class GetControllerTest extends AbstractTestCase
{
    public function testGetTags(): void
    {
        $tag = (new Tag())
            ->setName('Test');

        $this->setEntityId($tag, 1);

        $this->em->persist($tag);

        $this->client->request('GET', '/api/v1/doc/tags');

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
                        'required' => ['id', 'name'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'name' => ['type' => 'string'],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
