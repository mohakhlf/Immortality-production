<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagesRepository::class)
 */
class Images
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @ORM\OneToMany(targetEntity=Totem::class, mappedBy="image", orphanRemoval=true)
     */
    private $totems;

    public function __construct()
    {
        $this->totems = new ArrayCollection();
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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return Collection|Totem[]
     */
    public function getTotems(): Collection
    {
        return $this->totems;
    }

    public function addTotem(Totem $totem): self
    {
        if (!$this->totems->contains($totem)) {
            $this->totems[] = $totem;
            $totem->setImage($this);
        }

        return $this;
    }

    public function removeTotem(Totem $totem): self
    {
        if ($this->totems->contains($totem)) {
            $this->totems->removeElement($totem);
            // set the owning side to null (unless already changed)
            if ($totem->getImage() === $this) {
                $totem->setImage(null);
            }
        }

        return $this;
    }
}
