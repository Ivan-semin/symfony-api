<?php

namespace App\Controller\Article;

use App\Service\ArticleService;
use OpenApi\Attributes\Response as OAResponse;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteController extends AbstractController
{
    public function __construct(private readonly ArticleService $articleService)
    {
    }

    #[Route('/api/v1/doc/article/{id}', methods: ['DELETE'])]
    #[Tag(name: 'Article')]
    #[OAResponse(response: 200, description: 'Delete article')]
    public function deleteArticle(int $id): Response
    {
        try {
            $this->articleService->deleteArticle($id);

            return new Response('Delete article', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), $e->getCode());
        }
    }
}
