<?php

namespace App\Controller\Article;

use App\Service\ArticleService;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response as OAResponse;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetController extends AbstractController
{
    public function __construct(private readonly ArticleService $articleService)
    {
    }

    #[Route('/api/v1/doc/articles', methods: ['GET'])]
    #[OAResponse(response: 200, description: 'Get list article')]
    #[Parameter(
        name: 'filter',
        description: 'The field used to filter articles by tagId',
        in: 'query',
        schema: new Schema(type: 'string')
    )]
    #[Tag(name: 'Article')]
    public function getAllArticle(Request $request): Response
    {
        $tagIds = $request->query->has('filter') ?
            array_unique(
                array_map(
                    'intval',
                    explode(',', $request->query->get('filter'))
                )
            ) :
            null;

        return $this->json($this->articleService->getArticles($tagIds));
    }
}
