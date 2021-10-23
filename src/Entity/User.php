<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @JMS\Groups({"user_detail"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(groups={"Create"})
     * @JMS\Groups({"user_list", "user_detail"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(groups={"Create"})
     * @JMS\Groups({"user_list", "user_detail"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(groups={"Create"})
     * @JMS\Groups({"user_list", "user_detail"})
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity=MobilePhone::class)
     *
     * @Assert\NotBlank(groups={"Create"})
     * @JMS\Type("ArrayCollection<App\Entity\MobilePhone>")
     * @JMS\Groups({"user_detail"})
     */
    private $productsBuy;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="Users")
     * @ORM\JoinColumn(nullable=false)
     *
     * @JMS\Groups({"user_create"})
     */
    private $customer;

    public function __construct()
    {
        $this->productsBuy = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|MobilePhone[]
     */
    public function getProductsBuy(): Collection
    {
        return $this->productsBuy;
    }

    public function addProductsBuy(MobilePhone $productsBuy): self
    {
        if (!$this->productsBuy->contains($productsBuy)) {
            $this->productsBuy[] = $productsBuy;
        }

        return $this;
    }

    public function removeProductsBuy(MobilePhone $productsBuy): self
    {
        $this->productsBuy->removeElement($productsBuy);

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
