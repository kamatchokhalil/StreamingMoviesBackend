<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      formats= {"json"},
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 *     )
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Groups({"user:read", "user:write", "favoris:read","reviews:read"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     * @Groups({"user:read", "user:write", "favoris:read","reviews:read"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     * @Groups({"user:read", "user:write", "favoris:read","reviews:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write", "favoris:read","reviews:read"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write", "favoris:read","reviews:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write", "favoris:read","reviews:read"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="date")
     * @Groups({"user:read", "user:write", "favoris:read","reviews:read"})
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write", "favoris:read","reviews:read"})
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity=Reviews::class, mappedBy="userID", orphanRemoval=true, cascade={"persist"})
     */
    private $reviews;

    /**
     *@ORM\OneToMany(targetEntity=Favoris::class, mappedBy="userID", orphanRemoval=true)
     */
    private $favoris;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function toArray()
{
    return [
        'id' => $this->getId(),
        'name' => $this->getName(),
        'lastName' => $this->getLastName(),
        'email' => $this->getEmail(),
        'birthday' => $this->getBirthday(),
        'role'=> $this->getRole()
    ];
}

    public function getReviews(): ?Reviews
    {
        return $this->reviews;
    }

    public function setReviews(Reviews $reviews): self
    {
        // set the owning side of the relation if necessary
        if ($reviews->getUserID() !== $this) {
            $reviews->setUserID($this);
        }

        $this->reviews = $reviews;

        return $this;
    }

    public function getFavoris(): ?Favoris
    {
        return $this->favoris;
    }

    public function setFavoris(?Favoris $favoris): self
    {
        $this->favoris = $favoris;

        return $this;
    }




}
