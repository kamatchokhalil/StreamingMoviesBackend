<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FavorisRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     formats= {"json"},
 *     normalizationContext={"groups"={"favoris:read"}},
 *     denormalizationContext={"groups"={"favoris:write"}}
 *     )
 * )
 * @ApiFilter(SearchFilter::class, properties={"UserID":"ipartial","FilmID":"ipartial"})
 * @ORM\Entity(repositoryClass=FavorisRepository::class)
 */
class Favoris
{
    /**
     * @ORM\Id
     * @Groups({"favoris:read", "favoris:write"})
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"favoris:read", "favoris:write"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="favoris")
     * @ORM\JoinColumn(nullable=false)
     */
    private $UserID;

    /**
     * @Groups({"favoris:read", "favoris:write"})
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="favoris")
     * @ORM\JoinColumn(nullable=false)
     */
    private $FilmID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserID(): ?User
    {
        return $this->UserID;
    }

    public function setUserID(User $userID): self
    {
        $this->UserID = $userID;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFilmID()
    {
        return $this->FilmID;
    }

    /**
     * @param mixed $FilmID
     */
    public function setFilmID($FilmID): void
    {
        $this->FilmID = $FilmID;
    }


}
