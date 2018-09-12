<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActif;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $presentation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AppRole", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $appRole;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserCrew", mappedBy="user", orphanRemoval=true)
     */
    private $userCrews;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\IsLike", mappedBy="user")
     */
    private $isLikes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Statistic", mappedBy="user", orphanRemoval=true)
     */
    private $statistics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Quizz", mappedBy="author")
     */
    private $quizzs;

    public function __construct()
    {
        $this->userCrews = new ArrayCollection();
        $this->isLikes = new ArrayCollection();
        $this->statistics = new ArrayCollection();
        $this->quizzs = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAppRole(): ?AppRole
    {
        return $this->appRole;
    }

    public function setAppRole(?AppRole $appRole): self
    {
        $this->appRole = $appRole;

        return $this;
    }

    /**
     * @return Collection|UserCrew[]
     */
    public function getUserCrews(): Collection
    {
        return $this->userCrews;
    }

    public function addUserCrew(UserCrew $userCrew): self
    {
        if (!$this->userCrews->contains($userCrew)) {
            $this->userCrews[] = $userCrew;
            $userCrew->setUser($this);
        }

        return $this;
    }

    public function removeUserCrew(UserCrew $userCrew): self
    {
        if ($this->userCrews->contains($userCrew)) {
            $this->userCrews->removeElement($userCrew);
            // set the owning side to null (unless already changed)
            if ($userCrew->getUser() === $this) {
                $userCrew->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|IsLike[]
     */
    public function getIsLikes(): Collection
    {
        return $this->isLikes;
    }

    public function addIsLike(IsLike $isLike): self
    {
        if (!$this->isLikes->contains($isLike)) {
            $this->isLikes[] = $isLike;
            $isLike->setUser($this);
        }

        return $this;
    }

    public function removeIsLike(IsLike $isLike): self
    {
        if ($this->isLikes->contains($isLike)) {
            $this->isLikes->removeElement($isLike);
            // set the owning side to null (unless already changed)
            if ($isLike->getUser() === $this) {
                $isLike->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Statistic[]
     */
    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    public function addStatistic(Statistic $statistic): self
    {
        if (!$this->statistics->contains($statistic)) {
            $this->statistics[] = $statistic;
            $statistic->setUser($this);
        }

        return $this;
    }

    public function removeStatistic(Statistic $statistic): self
    {
        if ($this->statistics->contains($statistic)) {
            $this->statistics->removeElement($statistic);
            // set the owning side to null (unless already changed)
            if ($statistic->getUser() === $this) {
                $statistic->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Quizz[]
     */
    public function getQuizzs(): Collection
    {
        return $this->quizzs;
    }

    public function addQuizz(Quizz $quizz): self
    {
        if (!$this->quizzs->contains($quizz)) {
            $this->quizzs[] = $quizz;
            $quizz->setAuthor($this);
        }

        return $this;
    }

    public function removeQuizz(Quizz $quizz): self
    {
        if ($this->quizzs->contains($quizz)) {
            $this->quizzs->removeElement($quizz);
            // set the owning side to null (unless already changed)
            if ($quizz->getAuthor() === $this) {
                $quizz->setAuthor(null);
            }
        }

        return $this;
    }

    //implémentation de UserInterface => à modifier lorsqu'on mettra en place les différents ROLES
    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
    }

    public function getRoles()
    {
        return [$this->appRole->getCode()];
    }
}
