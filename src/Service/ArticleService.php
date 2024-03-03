<?php

namespace App\Service;

use App\Entity\Article;
use App\Model\Article\ArticleItem;
use App\Model\Article\ArticleListResponse;
use App\Model\Article\ArticleRequest;
use App\Repository\ArticleRepository;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class ArticleService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ArticleRepository $articleRepository,
        private readonly TagRepository $tagRepository
    ) {
    }

    public function getArticles(?array $tagIds): ArticleListResponse
    {
        $articles = $this->articleRepository->getArticlesByTagIds($tagIds);

        $items = array_map(
            fn (Article $article) => (new ArticleItem())
                ->setId($article->getId())
                ->setTitle($article->getTitle())
                ->setTags($article->getTags()->toArray()),
            $articles);

        return new ArticleListResponse($items);
    }

    public function getArticleById(int $id): ArticleItem
    {
        $article = $this->articleRepository->find($id);

        if (null === $article) {
            throw new \Exception(\sprintf('Article with id: %s, not found', $id), Response::HTTP_NOT_FOUND);
        }

        return (new ArticleItem())
            ->setId($article->getId())
            ->setTitle($article->getTitle())
            ->setTags($article->getTags()->toArray());
    }

    public function createArticle(ArticleRequest $request): ArticleItem
    {
        $article = (new Article())
            ->setTitle($request->getTitle())
            ->setTags(
                new ArrayCollection(array_map(fn ($tagId) => $this->tagRepository->find((int) $tagId) ?: throw new \Exception(\sprintf('Tag with id %s not found', $tagId), Response::HTTP_NOT_FOUND),
                    $request->getTags()))
            );

        $this->articleRepository->saveAndFlush($article);

        return (new ArticleItem())
            ->setId($article->getId())
            ->setTitle($article->getTitle())
            ->setTags($article->getTags()->toArray());
    }

    public function updateArticle(int $id, ArticleRequest $request): ArticleItem
    {
        $article = $this->articleRepository->find($id);

        if (null === $article) {
            throw new \Exception(\sprintf('Article with id: %s, not found', $id), Response::HTTP_NOT_FOUND);
        }

        $article
            ->setTitle($request->getTitle())
            ->setTags(
                new ArrayCollection(array_map(fn ($tagId) => $this->tagRepository->find((int) $tagId) ?: throw new \Exception(\sprintf('Tag with id %s not found', $tagId), Response::HTTP_NOT_FOUND),
                    $request->getTags()))
            );

        $this->articleRepository->saveAndFlush($article);

        return (new ArticleItem())
            ->setId($article->getId())
            ->setTitle($article->getTitle())
            ->setTags($article->getTags()->toArray());
    }

    public function deleteArticle(int $id): void
    {
        $article = $this->articleRepository->find($id);

        if (null === $article) {
            throw new \Exception(\sprintf('Article with id: %s, not found', $id), 404);
        }

        $this->em->remove($article);
        $this->em->flush();
    }
}
