<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleCrewRepository")
 */
class RoleCrew
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *? @Assert\NotBlank()
     *? @Assert\Length(
     *      min = 5,
     *      max = 64,
     *      minMessage = "la limite c'est {{ limit }} caractères",
     *      maxMessage = "max {{ limit }} caractères",
     *)
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserCrew", mappedBy="roleCrew")
     */
    private $userCrews;

    public function __construct()
    {
        $this->userCrews = new ArrayCollection();
    }

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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
            $userCrew->setRoleCrew($this);
        }

        return $this;
    }

    public function removeUserCrew(UserCrew $userCrew): self
    {
        if ($this->userCrews->contains($userCrew)) {
            $this->userCrews->removeElement($userCrew);
            // set the owning side to null (unless already changed)
            if ($userCrew->getRoleCrew() === $this) {
                $userCrew->setRoleCrew(null);
            }
        }

        return $this;
    }
}
