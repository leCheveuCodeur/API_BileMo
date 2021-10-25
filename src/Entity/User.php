<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *
 * @Hateoas\Relation(
 *  "self",
 *  href = @Hateoas\Route(
 *      "user_show",
 *       parameters = { "id" = "expr(object.getId())" },
 *       absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"user_details","user_list"})
 * )
 * @Hateoas\Relation(
 *  "put",
 *  href = @Hateoas\Route(
 *      "user_put",
 *      parameters = { "id" = "expr(object.getId())" },
 *      absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"user_details"})
 * )
 * @Hateoas\Relation(
 *  "delete",
 *  href = @Hateoas\Route(
 *      "user_delete",
 *       parameters = { "id" = "expr(object.getId())" },
 *       absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"user_details"})
 * )
 * @Hateoas\Relation(
 *  "list_all",
 *  href = @Hateoas\Route(
 *      "user_list",
 *       absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"user_details"})
 * )
 * @Hateoas\Relation(
 *  name="products_buy",
 *  embedded = @Hateoas\Embedded(
 *       "expr(object.getProductsBuy())",
 *       exclusion = @Hateoas\Exclusion(groups = {"user_details"})
 *      )
 * )
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @JMS\Groups({"user_details"})
     * @JMS\Since("1.0")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(groups={"Create"})
     * @JMS\Groups({"user_list", "user_details"})
     * @JMS\Since("1.0")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(groups={"Create"})
     * @JMS\Groups({"user_list", "user_details"})
     * @JMS\Since("1.0")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(groups={"Create"})
     * @JMS\Groups({"user_list", "user_details"})
     * @JMS\Since("1.0")
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity=MobilePhone::class)
     *
     * @Assert\NotBlank(groups={"Create"})
     * @JMS\Type("ArrayCollection<App\Entity\MobilePhone>")
     *
     * @JMS\Exclude
     * @JMS\Since("1.0")
     */
    private $productsBuy;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="Users")
     * @ORM\JoinColumn(nullable=false)
     *
     * @JMS\Groups({"user_create"})
     * @JMS\Since("1.0")
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
