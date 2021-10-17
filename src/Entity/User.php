<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FirstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\ManyToMany(targetEntity=MobilePhone::class)
     */
    private $ProductsBuy;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="Users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    public function __construct()
    {
        $this->ProductsBuy = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return Collection|MobilePhone[]
     */
    public function getProductsBuy(): Collection
    {
        return $this->ProductsBuy;
    }

    public function addProductsBuy(MobilePhone $productsBuy): self
    {
        if (!$this->ProductsBuy->contains($productsBuy)) {
            $this->ProductsBuy[] = $productsBuy;
        }

        return $this;
    }

    public function removeProductsBuy(MobilePhone $productsBuy): self
    {
        $this->ProductsBuy->removeElement($productsBuy);

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
