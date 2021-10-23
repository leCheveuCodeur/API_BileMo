<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected function paginate(QueryBuilder $qb, $maxPerPage = 20, $startedPage = 1)
    {
        if (0 == $maxPerPage || 0 == $startedPage) {
            throw new \LogicException('$maxPerPage & $startedPage must be greater than 0');
        }

        $pager = new Pagerfanta(new QueryAdapter($qb));
        $pager->setMaxPerPage((int) $maxPerPage)
            ->setCurrentPage($startedPage);

        return $pager;
    }
}
