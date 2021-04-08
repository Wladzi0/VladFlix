<?php

namespace App\Entity;

use App\Repository\SerialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SerialRepository::class)
 */
class Serial
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
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $yearStart;

    /**
     * @ORM\OneToMany(targetEntity=Season::class, mappedBy="serial",cascade={"persist", "remove"})
     */
    private $season;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="serials",cascade={"persist", "remove"})
     */
    private $categories;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $yearFinish;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ageCategory;

    public function __construct()
    {

        $this->season = new ArrayCollection();
        $this->categories = new ArrayCollection();
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }


    /**
     * @return Collection|Season[]
     */
    public function getSeason(): Collection
    {
        return $this->season;
    }

    public function addSeason(Season $season): self
    {
        if (!$this->season->contains($season)) {
            $this->season[] = $season;
            $season->setSerial($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): self
    {
        if ($this->season->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getSerial() === $this) {
                $season->setSerial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addSerial($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeSerial($this);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getYearStart()
    {
        return $this->yearStart;
    }

    /**
     * @param mixed $yearStart
     */
    public function setYearStart($yearStart): void
    {
        $this->yearStart = $yearStart;
    }

    /**
     * @return mixed
     */
    public function getYearFinish()
    {
        return $this->yearFinish;
    }

    /**
     * @param mixed $yearFinish
     */
    public function setYearFinish($yearFinish): void
    {
        $this->yearFinish = $yearFinish;
    }


    public function getAgeCategory(): ?bool
    {
        return $this->ageCategory;
    }

    public function setAgeCategory(?bool $ageCategory): self
    {
        $this->ageCategory = $ageCategory;

        return $this;
    }

}
