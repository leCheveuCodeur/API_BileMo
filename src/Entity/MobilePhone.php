<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Since;
use JMS\Serializer\Annotation as JMS;
use App\Repository\MobilePhoneRepository;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MobilePhoneRepository::class)
 *
 * @Hateoas\Relation(
 *  "self",
 *  href = @Hateoas\Route(
 *      "mobile_show",
 *       parameters = { "id" = "expr(object.getId())" },
 *       absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"mobile_details","user_details"})
 * )
 * @Hateoas\Relation(
 *  "list_all",
 *  href = @Hateoas\Route(
 *      "mobile_list",
 *       absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"mobile_details"})
 * )
 * @Hateoas\Relation(
 *  "self",
 *  href = @Hateoas\Route(
 *      "mobile_show",
 *       parameters = { "id" = "expr(object.getId())" },
 *       absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"mobile_list"})
 * )
 */
class MobilePhone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank(groups={"Create"})
     * @JMS\Groups({"mobile_details","user_details","user_create", "user_products"})
     * @JMS\Since("1.0")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @JMS\Groups({"mobile_list","mobile_details","user_details"})
     * @JMS\Since("1.0")
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @JMS\Groups({"mobile_list","mobile_details","user_details"})
     * @JMS\Since("1.0")
     */
    private $manufacturer;

    /**
     * @ORM\Column(type="integer")
     *
     * @JMS\Groups({"mobile_details"})
     * @JMS\Since("1.0")
     */
    private $year;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     *
     * @JMS\Groups({"mobile_details","user_details"})
     * @JMS\Since("1.0")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     *
     * @JMS\Groups({"mobile_details"})
     * @JMS\Since("1.0")
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
