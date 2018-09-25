<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatisticRepository")
 */
class Statistic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quizz", inversedBy="statistics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quizz;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="statistics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $result;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }


    public function getId() : ? int
    {
        return $this->id;
    }

    public function getQuizz() : ? Quizz
    {
        return $this->quizz;
    }

    public function setQuizz(? Quizz $quizz) : self
    {
        $this->quizz = $quizz;

        return $this;
    }

    public function getUser() : ? User
    {
        return $this->user;
    }

    public function setUser(? User $user) : self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt() : ? \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt) : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getResult() : ? int
    {
        return $this->result;
    }

    public function setResult(int $result) : self
    {
        $this->result = $result;

        return $this;
    }
}
