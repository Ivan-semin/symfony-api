<?php

namespace App\Controller\Article;

use App\Model\Article\ArticleItem;
use App\Service\ArticleService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes\Response as OAResponse;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetOneController extends AbstractController
{
    public function __construct(private readonly ArticleService $articleService)
    {
    }

    #[Route('/api/v1/doc/article/{id}', methods: ['GET'])]
    #[OAResponse(response: 200, description: 'Get article by id', attachables: [new Model(type: ArticleItem::class)])]
    #[OAResponse(response: 404, description: 'Not found')]
    #[Tag(name: 'Article')]
    public function getAllArticle(int $id): Response
    {
        try {
            return $this->json($this->articleService->getArticleById($id));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), $e->getCode());
        }
    }
}
