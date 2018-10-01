<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CrewQuizzsRepository")
 */
class CrewQuizzs
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Crew", inversedBy="crewQuizzs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $crew;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Quizz", inversedBy="crewQuizzs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Quizz;

    public function getCrew(): ?Crew
    {
        return $this->crew;
    }

    public function setCrew(?Crew $crew): self
    {
        $this->crew = $crew;

        return $this;
    }

    public function getQuizz(): ?Quizz
    {
        return $this->Quizz;
    }

    public function setQuizz(?Quizz $Quizz): self
    {
        $this->Quizz = $Quizz;

        return $this;
    }
}
