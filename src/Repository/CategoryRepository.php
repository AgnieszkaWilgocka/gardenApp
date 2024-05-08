<?php

namespace App\Repository;

use App\Dto\CategoryListFiltersDto;
use App\Dto\CategoryListInputFiltersDto;
use App\Entity\Category;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Species;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SpeciesRepository $speciesRepository)
    {
        parent::__construct($registry, Category::class);
    }

    public function queryAll(CategoryListFiltersDto $filters): QueryBuilder
    {
        $qb = $this->createQueryBuilder('category')
        ->orderBy('category.title', 'ASC');

        return $this->applyFilters($qb, $filters);
    }

    public function prepareFilters(CategoryListInputFiltersDto $filters): CategoryListFiltersDto
    {
        return new CategoryListFiltersDto(
        null !== $filters->speciesId ? $this->speciesRepository->findOneById($filters->speciesId) : null
        );
    }

    public function applyFilters(QueryBuilder $queryBuilder, CategoryListFiltersDto $filters): QueryBuilder
    {
        if($filters->species instanceof Species) {
            $queryBuilder->andWhere('category.species = :species')
            ->setParameter(':species', $filters->species);
        }

        return $queryBuilder;
    }

    // public function prepareFilters(VegetableListInputFiltersDto $filters): VegetableListFiltersDto
    // {
    //     return new VegetableListFiltersDto(
    //         null !== $filters->categoryId ?? $this->findOneById($filters->categoryId)
    //         // null !== $filters->categoryId ? $this->categoryService->findOneById($filters->categoryId) : null,
    //     );
    // }

    //    /**
    //     * @return Category[] Returns an array of Category objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Category
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
