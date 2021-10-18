<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;
use App\Repository\MobilePhoneRepository;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * @ORM\Entity(repositoryClass=MobilePhoneRepository::class)
 * @ExclusionPolicy("all")
 */
class MobilePhone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Expose
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Expose
     */
    private $manufacturer;

    /**
     * @ORM\Column(type="string")
     *
     * @Expose
     */
    private $year;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     *
     * @Expose
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     *
     * @Expose
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

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
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
