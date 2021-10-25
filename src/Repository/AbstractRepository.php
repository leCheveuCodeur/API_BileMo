<?php

namespace App\Repository;

use ArrayIterator;
use Bazinga\Bundle\HateoasBundle\Tests\Fixtures\UrlGenerator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Hateoas\Configuration\Route;
use Hateoas\HateoasBuilder;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Hateoas\Representation\OffsetRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Tests\Representation\PaginatedRepresentationTest;
use Hateoas\UrlGenerator\UrlGeneratorInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected function paginate(QueryBuilder $qb, string $route, $maxPerPage = 20, $startedPage = 1)
    {
        if (0 == $maxPerPage || 0 == $startedPage) {
            throw new \LogicException('$maxPerPage & $startedPage must be greater than 0');
        }

        if (empty($route)) {
            throw new \LogicException('$route cannot be empty.');
        }

        if (empty($qb)) {
            throw new \LogicException('Query cannot be empty.');
        }

        $pager = new Pagerfanta(new QueryAdapter($qb));
        $pager->setMaxPerPage((int) $maxPerPage)
            ->setCurrentPage($startedPage);

        $pagerfantaFactory = new PagerfantaFactory();
        $paginatedCollection = $pagerfantaFactory->createRepresentation(
            $pager,
            new Route($route, [], \true),
        );

        return $paginatedCollection;
    }
}
