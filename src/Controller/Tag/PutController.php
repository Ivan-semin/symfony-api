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
class PutController extends AbstractController
{
    public function __construct(private readonly TagService $tagService)
    {
    }

    #[Route('/api/v1/doc/tag/{id}', methods: ['PUT'])]
    #[OAResponse(response: 200, description: 'Update tag', attachables: [new Model(type: TagItem::class)])]
    #[OAResponse(response: 400, description: 'Validation failed')]
    #[RequestBody(attachables: [new Model(type: TagRequest::class)])]
    #[Tag(name: 'Tag')]
    public function createTag(int $id, TagRequest $request): Response
    {
        try {
            return $this->json($this->tagService->updateTag($id, $request));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), $e->getCode());
        }
    }
}
