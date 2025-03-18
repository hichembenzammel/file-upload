<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BandRepository")
 */
class Band
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $origin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="integer", length=255, nullable=true)
     */
    private $separation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fondateur;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $membre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $music;

    /**
     * @ORM\Column(type="string", length=10000, nullable=true)
     */
    private $presentation;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ConcertHall", inversedBy="bands")
     * @ORM\JoinTable(name="band_concerthalls")
     */
    private $concertHalls;

    public function __construct()
    {
        $this->concertHalls = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getConcertHalls(): ?\Doctrine\Common\Collections\Collection
    {
        return $this->concertHalls;
    }

    public function addConcertHall(ConcertHall $concertHall): self
    {
        if (!$this->concertHalls->contains($concertHall)) {
            $this->concertHalls[] = $concertHall;
        }

        return $this;
    }

    public function removeConcertHall(ConcertHall $concertHall): self
    {
        $this->concertHalls->removeElement($concertHall);

        return $this;
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

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getSeparation(): ?int
    {
        return $this->separation;
    }

    public function setSeparation(int $separation): self
    {
        $this->separation = $separation;

        return $this;
    }

    public function getFondateur(): ?string
    {
        return $this->fondateur;
    }

    public function setFondateur(string $fondateur): self
    {
        $this->fondateur = $fondateur;

        return $this;
    }
    public function getMembre(): ?string
    {
        return $this->membre;
    }

    public function setMembre(string $membre): self
    {
        $this->membre = $membre;

        return $this;
    }

    public function getMusic(): ?string
    {
        return $this->music;
    }

    public function setMusic(?string $music): self
    {
        $this->music = $music;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }
}
