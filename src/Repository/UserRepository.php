<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function search(int $customerId, string $route, string $order = 'asc', int $maxPerPages = 20, int $startedPage = 1)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.customer = :customerId')
            ->orderBy('u.id', $order)
            ->setParameter('customerId', $customerId);

        return $this->paginate($qb, $route, $maxPerPages, $startedPage);
    }
}
