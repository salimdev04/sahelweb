<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScoresRepository")
 */
class Scores
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstTeam;

    /**
     * @ORM\Column(type="smallint")
     */
    private $firstScore;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $secondTeam;

    /**
     * @ORM\Column(type="smallint")
     */
    private $secondScore;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstTeam(): ?string
    {
        return $this->firstTeam;
    }

    public function setFirstTeam(string $firstTeam): self
    {
        $this->firstTeam = $firstTeam;

        return $this;
    }

    public function getFirstScore(): ?int
    {
        return $this->firstScore;
    }

    public function setFirstScore(int $firstScore): self
    {
        $this->firstScore = $firstScore;

        return $this;
    }

    public function getSecondTeam(): ?string
    {
        return $this->secondTeam;
    }

    public function setSecondTeam(string $secondTeam): self
    {
        $this->secondTeam = $secondTeam;

        return $this;
    }

    public function getSecondScore(): ?int
    {
        return $this->secondScore;
    }

    public function setSecondScore(int $secondScore): self
    {
        $this->secondScore = $secondScore;

        return $this;
    }
}
