<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReviewsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     formats= {"json"},
 *     normalizationContext={"groups"={"reviews:read"}},
 *     denormalizationContext={"groups"={"reviews:write"}}
 *     )
 * )
 * @ORM\Entity(repositoryClass=ReviewsRepository::class)
 */
class Reviews
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Groups({"reviews:read", "reviews:write", "movie:read"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"reviews:read", "reviews:write"})
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movieID;

    /**
     * @Groups({"reviews:read", "reviews:write"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userID;

    /**
     * @Groups({"reviews:read", "reviews:write", "movie:read"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rate;

    /**
     * @Groups({"reviews:read", "reviews:write", "movie:read"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @Groups({"reviews:read", "reviews:write", "movie:read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $datecomment;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMovieID()
    {
        return $this->movieID;
    }

    /**
     * @param mixed $movieID
     */
    public function setMovieID($movieID): void
    {
        $this->movieID = $movieID;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID): void
    {
        $this->userID = $userID;
    }

    /**
     * @return mixed
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param mixed $rate
     */
    public function setRate($rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getDatecomment()
    {
        return $this->datecomment;
    }

    /**
     * @param mixed $datecomment
     */
    public function setDatecomment($datecomment): void
    {
        $this->datecomment = $datecomment;
    }




}
