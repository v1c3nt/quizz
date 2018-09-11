<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserCrewRepository")
 */
class UserCrew
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userCrews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Crew", inversedBy="members")
     * @ORM\JoinColumn(nullable=false)
     */
    private $crew;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RoleCrew", inversedBy="userCrews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $roleCrew;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCrew(): ?Crew
    {
        return $this->crew;
    }

    public function setCrew(?Crew $crew): self
    {
        $this->crew = $crew;

        return $this;
    }

    public function getRoleCrew(): ?RoleCrew
    {
        return $this->roleCrew;
    }

    public function setRoleCrew(?RoleCrew $roleCrew): self
    {
        $this->roleCrew = $roleCrew;

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
}
