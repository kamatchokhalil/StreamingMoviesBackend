<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StoreRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     formats= {"json"},
 *     normalizationContext={"groups"={"store:read"}},
 *     denormalizationContext={"groups"={"store:write"}}
 *     )
 * @ORM\Entity(repositoryClass=StoreRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"name,responsable,region","ipartial"})
 */
class Store
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"store:read", "store:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"store:read", "store:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"store:read", "store:write"})
     */
    private $responsible;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"store:read", "store:write"})
     */
    private $capacity;

    /**
     * @ORM\Column(type="float")
     * @Groups({"store:read", "store:write"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="float")
     * @Groups({"store:read", "store:write"})
     */
    private $laltitude;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"store:read", "store:write"})
     */
    private $availability;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"store:read", "store:write"})
     */
    private $region;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getResponsible(): ?string
    {
        return $this->responsible;
    }

    public function setResponsible(string $responsible): self
    {
        $this->responsible = $responsible;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLaltitude(): ?float
    {
        return $this->laltitude;
    }

    public function setLaltitude(float $laltitude): self
    {
        $this->laltitude = $laltitude;

        return $this;
    }

    public function getAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }
}
