<?php

namespace App\Repository;

use App\Dto\VegetableListFiltersDto;
use App\Dto\VegetableListInputFiltersDto;
use App\Entity\Category;
use App\Entity\Vegetable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends ServiceEntityRepository<Vegetable>
 *
 * @method Vegetable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vegetable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vegetable[]    findAll()
 * @method Vegetable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VegetableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private CategoryRepository $categoryRepository)
    {
        parent::__construct($registry, Vegetable::class);
    }

    public function queryForAll(VegetableListFiltersDto $filters) : QueryBuilder {
        $qb = $this->createQueryBuilder('vegetable')
        ->orderBy('vegetable.title', 'ASC');

        return $this->applyFilters($qb, $filters);
    }

    public function applyFilters(QueryBuilder $queryBuilder, VegetableListFiltersDto $filters): QueryBuilder
    {
        if($filters->category instanceof Category) {
            $queryBuilder->andWhere('vegetable.category = :category')
            ->setParameter(':category', $filters->category);
        }

        return $queryBuilder;
        // return $queryBuilder;
    }

    public function prepareFilters(VegetableListInputFiltersDto $filters): VegetableListFiltersDto
    {
        return new VegetableListFiltersDto(
            null !== $filters->categoryId ? $this->categoryRepository->findOneById($filters->categoryId) : null
        );
    }
    


    public function countCategory(Category $category): int
    {
        $qb = $this->createQueryBuilder('vegetable')
        ->select('COUNT(DISTINCT(vegetable.id))')
        ->andWhere('vegetable.category = :category')
        ->setParameter(':category', $category)
        ->getQuery()
        ->getSingleScalarResult();

        return $qb;
    }

    public function canDelete(Category $category): bool
    {
        try {
            $result = $this->countCategory($category);
            
            return $result == 0;
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }

    //    /**
    //     * @return Vegetable[] Returns an array of Vegetable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Vegetable
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
