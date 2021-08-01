<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     formats= {"json"},
 *     normalizationContext={"groups"={"annonce:read"}},
 *     denormalizationContext={"groups"={"annonce:write"}}
 *     )
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Groups({"annonce:read", "annonce:write", "categories:read"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"annonce:read", "annonce:write", "categories:read"})
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Groups({"annonce:read", "annonce:write", "categories:read"})
     * @ORM\Column(type="integer")
     */
    private $mediaType;

    /**
     * @Groups({"annonce:read", "annonce:write", "categories:read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $media;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMediaType(): ?int
    {
        return $this->mediaType;
    }

    public function setMediaType(int $mediaType): self
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
}
