<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Film::class, inversedBy="categories")
     */
    private $films;

    /**
     * @ORM\ManyToMany(targetEntity=Serial::class, inversedBy="categories")
     */
    private $serials;

    public function __construct()
    {
        $this->films = new ArrayCollection();
        $this->serials = new ArrayCollection();
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

    /**
     * @return Collection|Film[]
     */
    public function getFilms(): Collection
    {
        return $this->films;
    }

    public function addFilm(Film $film): self
    {
        if (!$this->films->contains($film)) {
            $this->films[] = $film;
        }

        return $this;
    }

    public function removeFilm(Film $film): self
    {
        $this->films->removeElement($film);

        return $this;
    }

    /**
     * @return Collection|Serial[]
     */
    public function getSerials(): Collection
    {
        return $this->serials;
    }

    public function addSerial(Serial $serial): self
    {
        if (!$this->serials->contains($serial)) {
            $this->serials[] = $serial;
        }

        return $this;
    }

    public function removeSerial(Serial $serial): self
    {
        $this->serials->removeElement($serial);

        return $this;
    }

    public function __toString()
    {
       return $this->name;
    }


}
