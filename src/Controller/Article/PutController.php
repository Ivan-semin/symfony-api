<?php

declare(strict_types=1);

namespace App\Controller\Article;

use App\Model\Article\ArticleItem;
use App\Model\Article\ArticleRequest;
use App\Service\ArticleService;
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
    public function __construct(private readonly ArticleService $articleService)
    {
    }

    #[Route('/api/v1/doc/article/{id}', methods: ['PUT'])]
    #[OAResponse(response: 200, description: 'Update article', attachables: [new Model(type: ArticleItem::class)])]
    #[OAResponse(response: 400, description: 'Validation failed')]
    #[RequestBody(attachables: [new Model(type: ArticleRequest::class)])]
    #[Tag(name: 'Article')]
    public function updateArticle(int $id, ArticleRequest $request): Response
    {
        try {
            return $this->json($this->articleService->updateArticle($id, $request));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), $e->getCode());
        }
    }
}
