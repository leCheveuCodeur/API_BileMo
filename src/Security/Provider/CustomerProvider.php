<?php

namespace App\Security\Provider;

use App\Entity\Customer;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class CustomerProvider  implements UserProviderInterface
{
    private $userLoader;

    public function __construct(UserloaderInterface $userLoader)
    {
        $this->userLoader = $userLoader;
    }

    public function loadUserByUsername(string $username) { }

    public function loadUserByIdentifier(string $identifier)
    {
        return $this->userLoader->loadUserByIdentifier($identifier);
    }

    public function refreshUser(UserInterface $user)
    {
    }

    public function supportsClass(string $class)
    {
        return $class === Customer::class;
    }

   
}
