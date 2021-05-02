<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FileRepository::class)
 */
class File
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\OneToOne(targetEntity=Film::class, mappedBy="file", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $film;

    /**
     * @ORM\OneToOne(targetEntity=Episode::class, mappedBy="file", cascade={"persist", "remove"})
     */
    private $episode;

    /**
     * @ORM\ManyToMany(targetEntity=TimeData::class, mappedBy="file")
     */
    private $timeData;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $subtitle = [];

    /**
     * @ORM\Column(type="array", nullable=false)
     */
    private $audio = [];

    /**
     * @ORM\Column(type="time")
     */
    private $duration;


    public function __construct()
    {
        $this->timeData = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param mixed $subtitle
     */
    public function setSubtitle($subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    /**
     * @return mixed
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * @param mixed $audio
     */
    public function setAudio($audio): void
    {
        $this->audio = $audio;
    }



    public function getFilm(): ?Film
    {
        return $this->film;
    }

    public function setFilm(Film $film): self
    {
        // set the owning side of the relation if necessary
        if ($film->getFile() !== $this) {
            $film->setFile($this);
        }

        $this->film = $film;

        return $this;
    }

    public function getEpisode(): ?Episode
    {
        return $this->episode;
    }

    public function setEpisode(Episode $episode): self
    {
        // set the owning side of the relation if necessary
        if ($episode->getFile() !== $this) {
            $episode->setFile($this);
        }

        $this->episode = $episode;

        return $this;
    }

    /**
     * @return Collection|TimeData[]
     */
    public function getTimeData(): Collection
    {
        return $this->timeData;
    }

    public function addTimeData(TimeData $timeData): self
    {
        if (!$this->timeData->contains($timeData)) {
            $this->timeData[] = $timeData;
            $timeData->addFile($this);
        }

        return $this;
    }

    public function removeTimeData(TimeData $timeData): self
    {
        if ($this->timeData->removeElement($timeData)) {
            $timeData->removeFile($this);
        }

        return $this;
    }

public function __toString()
{

 return $this->path;
}

public function getDuration(): ?\DateTimeInterface
{
    return $this->duration;
}

public function setDuration(\DateTimeInterface $duration): self
{
    $this->duration = $duration;

    return $this;
}
}
