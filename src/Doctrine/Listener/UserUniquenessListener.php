<?php

namespace App\Doctrine\Listener;

use Exception;
use App\Entity\User;
use App\Repository\UserRepository;

class UserUniquenessListener
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function prePersist(User $user)
    {
        $userExist = $this->userRepository->createQueryBuilder('u')
        ->where('u.customer = :customer')
        ->andWhere('u.email = :user')
        ->setParameter('customer', $user->getCustomer())
        ->setParameter('user',$user->getEmail())
        ->getQuery()
        ->getResult();

        if ($userExist){
            throw new Exception("This email already exists");
        }
    }
}
