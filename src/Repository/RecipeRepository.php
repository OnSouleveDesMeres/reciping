<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * @param $value
     * @return Recipe[]
     */
    public function findByContainName($value)
    {
        return $this->createQueryBuilder('r')
            ->where('r.name LIKE :value')
            ->setParameter('value', '%'.$value.'%')
            ->getQuery()
            ->getResult()
        ;
    }

}
