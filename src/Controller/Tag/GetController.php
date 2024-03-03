<?php

namespace App\Controller\Tag;

use App\Service\TagService;
use OpenApi\Attributes\Response as OAResponse;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetController extends AbstractController
{
    public function __construct(private readonly TagService $tagService)
    {
    }

    #[Route('/api/v1/doc/tags', methods: ['GET'])]
    #[OAResponse(response: 200, description: 'Get list tag')]
    #[Tag(name: 'Tag')]
    public function getAllTag(): Response
    {
        return $this->json($this->tagService->getTags());
    }
}
