<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ApiResource(
 *      formats= {"json"},
 *     normalizationContext={"groups"={"movie:read"}},
 *     denormalizationContext={"groups"={"movie:write"}}
 *     )
 * )
 * @ApiFilter(SearchFilter::class, properties={"title":"ipartial","MovieCategories":"ipartial","quality":"ipartial"})
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Groups({"movie:read", "movie:write", "movieCategories:read", "favoris:read"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"movie:read", "movie:write", "movieCategories:read", "favoris:read"})
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Groups({"movie:read", "movie:write", "movieCategories:read", "favoris:read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $summary;

    /**
     * @Groups({"movie:read", "movie:write", "movieCategories:read", "favoris:read"})
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @Groups({"movie:read", "movie:write", "movieCategories:read", "favoris:read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duration;

    /**
     * @Groups({"movie:read", "movie:write", "movieCategories:read", "favoris:read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quality;

    /**
     * @Groups({"movie:read", "movie:write", "movieCategories:read", "favoris:read"})
     * @ORM\Column(type="boolean")
     */
    private $trans;

    /**
     * @Groups({"movie:read", "movie:write", "movieCategories:read", "favoris:read"})
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateSortie;

    /**
     * @Groups({"movie:read", "movie:write", "movieCategories:read", "favoris:read"})
     * @ORM\Column(type="integer", nullable=false)
     */
    private $numVisits;

    /**
     * @Groups({"movie:read", "movie:write", "movieCategories:read", "favoris:read"})
     * @ORM\Column(type="float", nullable=true)
     */
    private $overallRate;

    /**
     * @Groups({"movie:read", "movie:write"})
     * @ORM\ManyToOne(targetEntity=MovieCategories::class, inversedBy="movies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $MovieCategories;

    /**
     * @Groups({"movie:read", "movie:write", "movieCategories:read", "favoris:read"})
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @Groups({"movie:read", "movie:write", "movieCategories:read", "favoris:read"})
     * @ORM\Column(type="boolean")
     */
    private $free;

    /**
     * @Groups({"movie:read", "movie:write"})
     * @ORM\OneToMany(targetEntity=Reviews::class, mappedBy="movieID", orphanRemoval=true)
     */
    private $reviews;

    /**
     * @Groups({"movie:read", "movie:write"})
     * @ORM\OneToMany(targetEntity=Favoris::class, mappedBy="FilmID", orphanRemoval=true)
     */
    private $favoris;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
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

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getQuality(): ?string
    {
        return $this->quality;
    }

    public function setQuality(?string $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getTrans(): ?bool
    {
        return $this->trans;
    }

    public function setTrans(bool $trans): self
    {
        $this->trans = $trans;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(?\DateTimeInterface $dateSortie): self
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getNumVisits(): int
    {
        return $this->numVisits;
    }

    public function setNumVisits(int $numVisits): self
    {
        $this->numVisits = $numVisits;

        return $this;
    }

    public function getOverallRate(): ?float
    {
        return $this->overallRate;
    }

    public function setOverallRate(?float $overallRate): self
    {
        $this->overallRate = $overallRate;

        return $this;
    }

    public function getMovieCategories(): ?MovieCategories
    {
        return $this->MovieCategories;
    }

    public function setMovieCategories(?MovieCategories $MovieCategories): self
    {
        $this->MovieCategories = $MovieCategories;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getFree(): ?bool
    {
        return $this->free;
    }

    public function setFree(bool $free): self
    {
        $this->free = $free;

        return $this;
    }

    /**
     * @return Collection|Reviews[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setMovieID($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getMovieID() === $this) {
                $review->setMovieID(null);
            }
        }

        return $this;
    }

/*    public function getFavoris(): ?Favoris
    {
        return $this->favoris;
    }

    public function setFavoris(?Favoris $favoris): self
    {
        $this->favoris = $favoris;

        return $this;
    }*/
}
