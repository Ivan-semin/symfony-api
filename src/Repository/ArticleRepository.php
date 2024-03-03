<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly EntityManagerInterface $em)
    {
        parent::__construct($registry, Article::class);
    }

    public function saveAndFlush(Article $article): void
    {
        $this->em->persist($article);
        $this->em->flush();
    }

    public function getArticlesByTagIds(?array $tagIds): array
    {
        $qb = $this->createQueryBuilder('a')
            ->addOrderBy('a.id', 'ASC');

        if (is_array($tagIds)) {
            $qb
                ->join('a.tags', 't')
                ->andWhere('t.id IN (:tags)')->setParameter('tags', $tagIds);
        }

        return $qb->getQuery()->getResult();
    }
}
