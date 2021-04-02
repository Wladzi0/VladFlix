<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class Profile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Your nickname must be at least {{ limit }} characters long",
     *      maxMessage = "Your nickname cannot be longer than {{ limit }} characters"
     * )
     */
    private $nickname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $backgroundColor;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="profiles")
     */
    private $user;

    /**
     * @ORM\Column(type="string",nullable=true,  length=4)
     * @Assert\Length(
     *      min = 4,
     *      max = 4,
     *      minMessage = "Your pin must be at least {{ limit }} characters long",
     *      maxMessage = "Your pin cannot be longer than {{ limit }} characters"
     * )
     */
    private $profilePin;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $interfaceLanguage;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $preferredLanguage;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $preferredAudio;

    /**
     * @ORM\ManyToMany(targetEntity=TimeData::class, mappedBy="profile")
     */
    private $timeData;

    public function __construct()
    {
        $this->timeData = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(string $backgroundColor): self
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }


    public function setAge($age): void
    {
        $this->age = $age;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getProfilePin()
    {
        return $this->profilePin;
    }

    /**
     * @param mixed $profilePin
     */
    public function setProfilePin($profilePin): void
    {
        $this->profilePin = $profilePin;
    }

    /**
     * @return mixed
     */
    public function getInterfaceLanguage()
    {
        return $this->interfaceLanguage;
    }

    /**
     * @param mixed $interfaceLanguage
     */
    public function setInterfaceLanguage($interfaceLanguage): void
    {
        $this->interfaceLanguage = $interfaceLanguage;
    }

    public function getPreferredLanguage(): ?string
    {
        return $this->preferredLanguage;
    }

    public function setPreferredLanguage(?string $preferredLanguage): self
    {
        $this->preferredLanguage = $preferredLanguage;

        return $this;
    }

    public function getPreferredAudio(): ?string
    {
        return $this->preferredAudio;
    }

    public function setPreferredAudio(?string $preferredAudio): self
    {
        $this->preferredAudio = $preferredAudio;

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
            $timeData->addProfile($this);
        }

        return $this;
    }

    public function removeTimeData(TimeData $timeData): self
    {
        if ($this->timeData->removeElement($timeData)) {
            $timeData->removeProfile($this);
        }

        return $this;
    }



}
