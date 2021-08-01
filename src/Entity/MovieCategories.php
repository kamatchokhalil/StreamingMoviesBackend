<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MovieCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 *     formats= {"json"},
 *     normalizationContext={"groups"={"movieCategories:read"}},
 *     denormalizationContext={"groups"={"movieCategories:write"}}
 *     )
 * )
 * @ApiFilter(SearchFilter::class, properties={"title","ipartial"})
 * @ORM\Entity(repositoryClass=MovieCategoriesRepository::class)
 */
class MovieCategories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Groups({"movieCategories:read", "movieCategories:write"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"movieCategories:read", "movieCategories:write"})
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Groups({"movieCategories:read", "movieCategories:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @Groups({"movieCategories:read", "movieCategories:write"})
     * @ORM\OneToMany(targetEntity=Movie::class, mappedBy="MovieCategories", orphanRemoval=true, cascade={"persist"})
     */
    private $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->setMovieCategories($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            // set the owning side to null (unless already changed)
            if ($movie->getMovieCategories() === $this) {
                $movie->setMovieCategories(null);
            }
        }

        return $this;
    }
}
