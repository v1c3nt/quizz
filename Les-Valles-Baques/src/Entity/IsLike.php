<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IsLikeRepository")
 */
class IsLike
{
    /**
     * @ORM\Column(type="boolean")
     */
    private $likeIt;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="isLikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Quizz", inversedBy="isLikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quizz;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLikeIt(): ?bool
    {
        return $this->likeIt;
    }

    public function setLikeIt(bool $likeIt): self
    {
        $this->likeIt = $likeIt;

        return $this;
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

    public function getQuizz(): ?Quizz
    {
        return $this->quizz;
    }

    public function setQuizz(?Quizz $quizz): self
    {
        $this->quizz = $quizz;

        return $this;
    }
}
