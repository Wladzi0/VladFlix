<?php

namespace App\Entity;

use App\Repository\TimeDataRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TimeDataRepository::class)
 */
class TimeData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFinished = false;

    /**
     * @ORM\ManyToMany(targetEntity=Profile::class, inversedBy="timeData")
     */
    private $profile;

    /**
     * @ORM\ManyToMany(targetEntity=File::class, inversedBy="timeData")
     */
    private $file;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $curTime;

    public function __construct()
    {
        $this->profile = new ArrayCollection();
        $this->file = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(?bool $isFinished): self
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    /**
     * @return Collection|Profile[]
     */
    public function getProfile(): Collection
    {
        return $this->profile;
    }

    public function addProfile(Profile $profile): self
    {
        if (!$this->profile->contains($profile)) {
            $this->profile[] = $profile;
        }

        return $this;
    }

    public function removeProfile(Profile $profile): self
    {
        $this->profile->removeElement($profile);

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getFile(): Collection
    {
        return $this->file;
    }

    public function addFile(File $file): self
    {
        if (!$this->file->contains($file)) {
            $this->file[] = $file;
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        $this->file->removeElement($file);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurTime()
    {
        return $this->curTime;
    }

    /**
     * @param mixed $curTime
     */
    public function setCurTime($curTime): void
    {
        $this->curTime = $curTime;
    }


}
