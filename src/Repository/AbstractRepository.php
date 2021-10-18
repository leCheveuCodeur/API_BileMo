<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected function paginate(QueryBuilder $qb, $limit = 20, $offset = 1)
    {
        if (0 == $limit || 0 == $offset) {
            throw new \LogicException('$limit & $offset must be greater than 0');
        }

        $pager = new Pagerfanta(new QueryAdapter($qb));
        $currentPage = $offset;
        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage((int) $limit);

        return $pager;
    }
}
