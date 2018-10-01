<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CrewRepository")
 * @Vich\Uploadable
 */
class Crew
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 1,
     *      max = 128,
     *      minMessage = " ' ' c''est pas nom ça c'est ... vide  ",
     *      maxMessage = "Un nom de groupe de plus de {{ limit }} caractères c'est Heuuu ... trop long",
     * )
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=12)
     */
    private $slug;

    /**
     * ! a mettre plus tard
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" }),
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * ! a mettre plus tard
     * @Vich\UploadableField(mapping="avatar_image", fileNameProperty="avatar")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatarFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserCrew", mappedBy="crew", orphanRemoval=true)
     */
    private $members;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Quizz", mappedBy="crew")
     */
    private $quizzs;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $isPrivate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CrewQuizzs", mappedBy="crew")
     */
    private $crewQuizzs;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->quizzs = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->crewQuizzs = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getName() : ? string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug() : ? string
    {
        return $this->slug;
    }

    public function setSlug(string $slug) : self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     *
     * @param File|UploadedFile $image
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this->avatar;
    }

    public function setAvatarFile(? File $image = null) : void
    {
        $this->avatarFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getAvatarFile() : ? File
    {
        return $this->avatarFile;
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

    /**
     * @return Collection|UserCrew[]
     */
    public function getMembers() : Collection
    {
        return $this->members;
    }

    public function addMember(UserCrew $member) : self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setCrew($this);
        }

        return $this;
    }

    public function removeMember(UserCrew $member) : self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            // set the owning side to null (unless already changed)
            if ($member->getCrew() === $this) {
                $member->setCrew(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Quizz[]
     */
    public function getQuizzs() : Collection
    {
        return $this->quizzs;
    }

    public function addQuizz(Quizz $quizz) : self
    {
        if (!$this->quizzs->contains($quizz)) {
            $this->quizzs[] = $quizz;
            $quizz->setCrew($this);
        }

        return $this;
    }

    public function removeQuizz(Quizz $quizz) : self
    {
        if ($this->quizzs->contains($quizz)) {
            $this->quizzs->removeElement($quizz);
            // set the owning side to null (unless already changed)
            if ($quizz->getCrew() === $this) {
                $quizz->setCrew(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getDescription() : ? string
    {
        return $this->description;
    }

    public function setDescription(? string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsPrivate() : ? int
    {
        return $this->isPrivate;
    }

    public function setIsPrivate(int $isPrivate) : self
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }

    /**
     * @return Collection|CrewQuizzs[]
     */
    public function getCrewQuizzs(): Collection
    {
        return $this->crewQuizzs;
    }

    public function addCrewQuizz(CrewQuizzs $crewQuizz): self
    {
        if (!$this->crewQuizzs->contains($crewQuizz)) {
            $this->crewQuizzs[] = $crewQuizz;
            $crewQuizz->setCrew($this);
        }

        return $this;
    }

    public function removeCrewQuizz(CrewQuizzs $crewQuizz): self
    {
        if ($this->crewQuizzs->contains($crewQuizz)) {
            $this->crewQuizzs->removeElement($crewQuizz);
            // set the owning side to null (unless already changed)
            if ($crewQuizz->getCrew() === $this) {
                $crewQuizz->setCrew(null);
            }
        }

        return $this;
    }
}
