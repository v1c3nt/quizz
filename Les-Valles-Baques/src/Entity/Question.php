<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * ! a mettre plus tard 
     * @Vich\UploadableField(mapping="question_image", fileNameProperty="image")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageFile;

    /**
     *? @Assert\NotBlank()
     *? @Assert\Length(
     *      min = 10,
     *      max = 255,
     *      minMessage = "Une question en moins de {{ limit }} caractères ? Je suis pas sûr ... ",
     *      maxMessage = "C'est plus une question c'est un roman ?",
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $body;

    /**
     *? @Assert\NotBlank()
     *? @Assert\Length(
     *      min = 1,
     *      max = 128,
     *      minMessage = "Une réponse vide c'est ... vide  ",
     *      maxMessage = "Désolé ta réponse et trop longue",
     * )
     * @ORM\Column(type="string", length=128)
     */
    private $prop1;

    /**
     *? @Assert\NotBlank()
     *? @Assert\Length(
     *      min = 1,
     *      max = 128,
     *      minMessage = "Une réponse vide c'est ... vide ",
     *      maxMessage = "Désolé ta réponse et trop longue",
     * )
     * @ORM\Column(type="string", length=128)
     */
    private $prop2;

    /**
     *? @Assert\NotBlank()
     *? @Assert\Length(
     *      min = 1,
     *      max = 128,
     *      minMessage = "Une réponse vide c'est ... vide  ",
     *      maxMessage = "Désolé ta réponse et trop longue",
     * )
     * @ORM\Column(type="string", length=128)
     */
    private $prop3;

    /**
     *? @Assert\NotBlank()
     *? @Assert\Length(
     *      min = 1,
     *      max = 128,
     *      minMessage = "Une réponse vide c'est ... vide  ",
     *      maxMessage = "Désolé ta réponse et trop longue",
     * )
     * @ORM\Column(type="string", length=128)
     */
    private $prop4;

    /**
     *? @Assert\Length(
     *      max = 255,
     *      maxMessage = "Sois plus concis (max {{ limit }} caratères",
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $anecdote;

    /**
     * ? @Assert\Url(),
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $source;

    /**
     * @ORM\Column(type="boolean")
     */
    private $errore;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quizz", inversedBy="questions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $quizz;

    /**
     * ? @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="App\Entity\Level", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

    /**
     * @ORM\Column(type="integer")
     */ 
    private $nbr;

    /**
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" }),
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getBody() : ? string
    {
        return $this->body;
    }

    public function setBody(string $body) : self
    {
        $this->body = $body;

        return $this;
    }

    public function getProp1() : ? string
    {
        return $this->prop1;
    }

    public function setProp1(string $prop1) : self
    {
        $this->prop1 = $prop1;

        return $this;
    }

    public function getProp2() : ? string
    {
        return $this->prop2;
    }

    public function setProp2(string $prop2) : self
    {
        $this->prop2 = $prop2;

        return $this;
    }

    public function getProp3() : ? string
    {
        return $this->prop3;
    }

    public function setProp3(string $prop3) : self
    {
        $this->prop3 = $prop3;

        return $this;
    }

    public function getProp4() : ? string
    {
        return $this->prop4;
    }

    public function setProp4(string $prop4) : self
    {
        $this->prop4 = $prop4;

        return $this;
    }

    public function getAnecdote() : ? string
    {
        return $this->anecdote;
    }

    public function setAnecdote(? string $anecdote) : self
    {
        $this->anecdote = $anecdote;

        return $this;
    }

    public function getSource() : ? string
    {
        return $this->source;
    }

    public function setSource(? string $source) : self
    {
        $this->source = $source;

        return $this;
    }

    public function getErrore() : ? bool
    {
        return $this->errore;
    }

    public function setErrore(bool $errore) : self
    {
        $this->errore = $errore;

        return $this;
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

    public function getLevel() : ? Level
    {
        return $this->level;
    }

    public function setLevel(? Level $level) : self
    {
        $this->level = $level;

        return $this;
    }

    public function getNbr() : ? int
    {
        return $this->nbr;
    }
    public function setNbr(int $nbr) : self
    {
        $this->nbr = $nbr;
        return $this;
    }

    public function __toString()
    {
        return $this->getBody();
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
    *
    * @param File|UploadedFile $image
    */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setImageFile(? File $image = null) : void
    {
        $this->imageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();

        }
    }


    public function getImageFile() : ? File
    {
        return $this->imageFile;
    }


}
