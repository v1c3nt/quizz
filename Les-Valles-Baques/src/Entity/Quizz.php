<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuizzRepository")
 */
class Quizz
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
     *      min = 1,
     *      max = 128,
     *      minMessage = "Tu manques d'instiration ... ok mais la c'est trop court ",
     *      maxMessage = "C'est pas la taille l'important. La c'est trop long ",
     * )
     * @ORM\Column(type="string", length=128)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $IsPrivate;

    /**
     *? @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="quizzs")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="quizz", orphanRemoval=true)
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\IsLike", mappedBy="quizz")
     */
    private $isLikes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Statistic", mappedBy="quizz", orphanRemoval=true)
     */
    private $statistics;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="quizzs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crew", inversedBy="quizzs")
     */
    private $crew;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Level", inversedBy="quizzs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrLikes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $avgScore;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->isLikes = new ArrayCollection();
        $this->statistics = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsPrivate() : ? bool
    {
        return $this->IsPrivate;
    }

    public function setIsPrivate(? bool $IsPrivate) : self
    {
        $this->IsPrivate = $IsPrivate;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setQuizz($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getQuizz() === $this) {
                $question->setQuizz(null);
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
    
    public function setIsLikes() : Collection
    {
        return $this->isLikes;
    }

    public function addIsLike(IsLike $isLike): self
    {
        if (!$this->isLikes->contains($isLike)) {
            $this->isLikes[] = $isLike;
            $isLike->setQuizz($this);
        }

        return $this;
    }

    public function removeIsLike(IsLike $isLike): self
    {
        if ($this->isLikes->contains($isLike)) {
            $this->isLikes->removeElement($isLike);
            // set the owning side to null (unless already changed)
            if ($isLike->getQuizz() === $this) {
                $isLike->setQuizz(null);
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
            $statistic->setQuizz($this);
        }

        return $this;
    }

    public function removeStatistic(Statistic $statistic): self
    {
        if ($this->statistics->contains($statistic)) {
            $this->statistics->removeElement($statistic);
            // set the owning side to null (unless already changed)
            if ($statistic->getQuizz() === $this) {
                $statistic->setQuizz(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

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

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    public function getNbrLikes(): ?int
    {
        return $this->nbrLikes;
    }

    public function setNbrLikes(?int $nbrLikes): self
    {
        $this->nbrLikes = $nbrLikes;

        return $this;
    }

    public function getAvgScore(): ?int
    {
        return $this->avgScore;
    }

    public function setAvgScore(?int $avgScore): self
    {
        $this->avgScore = $avgScore;

        return $this;
    }


}
