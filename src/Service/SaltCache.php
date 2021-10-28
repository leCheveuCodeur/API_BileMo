<?php

namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SaltCache
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function salt()
    {
        return \preg_replace('/\W/', '_', $this->token->getToken()->getUserIdentifier());
    }
}
