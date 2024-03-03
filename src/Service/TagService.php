<?php

namespace App\Service;

use App\Entity\Tag;
use App\Model\Tag\TagItem;
use App\Model\Tag\TagListResponse;
use App\Model\Tag\TagRequest;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Response;

class TagService
{
    public function __construct(
        private readonly TagRepository $tagRepository
    ) {
    }

    public function createTag(TagRequest $request): TagItem
    {
        $tag = (new Tag())->setName($request->getName());

        $this->tagRepository->saveAndFlush($tag);

        return (new TagItem())
            ->setId($tag->getId())
            ->setName($tag->getName());
    }

    public function updateTag(int $id, TagRequest $request): TagItem
    {
        $tag = $this->tagRepository->find($id);

        if (null === $tag) {
            throw new \Exception(\sprintf('Tag with id: %s, not found', $id), Response::HTTP_NOT_FOUND);
        }

        $tag->setName($request->getName());

        $this->tagRepository->saveAndFlush($tag);

        return (new TagItem())
            ->setId($tag->getId())
            ->setName($tag->getName());
    }

    public function getTags(): TagListResponse
    {
        $categories = $this->tagRepository->findBy([], ['id' => 'ASC']);

        $items = array_map(
            fn (Tag $tag) => (new TagItem())
                ->setId($tag->getId())
                ->setName($tag->getName()),
            $categories);

        return new TagListResponse($items);
    }
}
