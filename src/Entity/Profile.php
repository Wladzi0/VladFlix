<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\Column(type="json")
     */
    private $roles = ['ROLE_USER'];

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
     * @ORM\Column(type="string",nullable=true)
     * @Assert\Length(
     *      min = 4,
     *      max = 4,
     *      minMessage = "Your pin must be at least {{ limit }} characters long",
     *      maxMessage = "Your pin cannot be longer than {{ limit }} characters"
     * )
     */
    private $pin;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $interfaceLanguage;

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

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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

    public function getPin(): ?int
    {
        return $this->pin;
    }

    public function setPin(int $pin): self
    {
        $this->pin = $pin;

        return $this;
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


}
