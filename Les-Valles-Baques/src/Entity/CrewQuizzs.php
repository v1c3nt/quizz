<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CrewQuizzsRepository")
 */
class CrewQuizzs
{
    /**
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Id()
     * @ORM\ManyToMany(targetEntity="App\Entity\Quizz")
     */
    private $quizz;

    /**
     * @ORM\Id()
     * @ORM\ManyToMany(targetEntity="App\Entity\Crew")
     */
    private $crew;

    public function __construct()
    {
        $this->quizz = new ArrayCollection();
        $this->crew = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Quizz[]
     */
    public function getQuizz(): Collection
    {
        return $this->quizz;
    }

    public function addQuizz(Quizz $quizz): self
    {
        if (!$this->quizz->contains($quizz)) {
            $this->quizz[] = $quizz;
        }

        return $this;
    }

    public function removeQuizz(Quizz $quizz): self
    {
        if ($this->quizz->contains($quizz)) {
            $this->quizz->removeElement($quizz);
        }

        return $this;
    }

    /**
     * @return Collection|Crew[]
     */
    public function getCrew(): Collection
    {
        return $this->crew;
    }

    public function addCrew(Crew $crew): self
    {
        if (!$this->crew->contains($crew)) {
            $this->crew[] = $crew;
        }

        return $this;
    }

    public function removeCrew(Crew $crew): self
    {
        if ($this->crew->contains($crew)) {
            $this->crew->removeElement($crew);
        }

        return $this;
    }
}
