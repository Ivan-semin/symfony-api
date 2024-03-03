<?php

namespace App\Controller\Tag;

use App\Model\Tag\TagItem;
use App\Model\Tag\TagRequest;
use App\Service\TagService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response as OAResponse;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class PostController extends AbstractController
{
    public function __construct(private readonly TagService $tagService)
    {
    }

    #[Route('/api/v1/doc/tag', methods: ['POST'])]
    #[OAResponse(response: 200, description: 'Create tag', attachables: [new Model(type: TagItem::class)])]
    #[OAResponse(response: 400, description: 'Validation failed')]
    #[RequestBody(attachables: [new Model(type: TagRequest::class)])]
    #[Tag(name: 'Tag')]
    public function createTag(TagRequest $request): Response
    {
        try {
            return $this->json($this->tagService->createTag($request));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), $e->getCode());
        }
    }
}
