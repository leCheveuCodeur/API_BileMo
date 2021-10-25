<?php

namespace App\Repository;

use App\Entity\MobilePhone;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MobilePhone|null find($id, $lockMode = null, $lockVersion = null)
 * @method MobilePhone|null findOneBy(array $criteria, array $orderBy = null)
 * @method MobilePhone[]    findAll()
 * @method MobilePhone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MobilePhoneRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MobilePhone::class);
    }

    public function search(string $route, string $order = 'asc', int $maxPerPages = 20, int $startedPage = 1)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m')
            ->orderBy('m.id', $order);

        return $this->paginate($qb, $route, $maxPerPages, $startedPage);
    }
}
