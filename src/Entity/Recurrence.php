<?php

namespace App\Entity;

use App\Repository\RecurrenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecurrenceRepository::class)
 */
class Recurrence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $morning;

    /**
     * @ORM\Column(type="integer")
     */
    private $noon;

    /**
     * @ORM\Column(type="integer")
     */
    private $evening;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\ManyToMany(targetEntity=Treatment::class, mappedBy="recurrence")
     */
    private $treatments;

    /**
     * @ORM\OneToOne(targetEntity=Drug::class, mappedBy="recurrence", cascade={"persist", "remove"})
     */
    private $drug;

    public function __construct()
    {
        $this->treatments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMorning(): ?int
    {
        return $this->morning;
    }

    public function setMorning(int $morning): self
    {
        $this->morning = $morning;

        return $this;
    }

    public function getNoon(): ?int
    {
        return $this->noon;
    }

    public function setNoon(int $noon): self
    {
        $this->noon = $noon;

        return $this;
    }

    public function getEvening(): ?int
    {
        return $this->evening;
    }

    public function setEvening(int $evening): self
    {
        $this->evening = $evening;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return Collection|Treatment[]
     */
    public function getTreatments(): Collection
    {
        return $this->treatments;
    }

    public function addTreatment(Treatment $treatment): self
    {
        if (!$this->treatments->contains($treatment)) {
            $this->treatments[] = $treatment;
            $treatment->addRecurrence($this);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): self
    {
        if ($this->treatments->contains($treatment)) {
            $this->treatments->removeElement($treatment);
            $treatment->removeRecurrence($this);
        }

        return $this;
    }

    public function getDrug(): ?Drug
    {
        return $this->drug;
    }

    public function setDrug(?Drug $drug): self
    {
        $this->drug = $drug;

        // set (or unset) the owning side of the relation if necessary
        $newRecurrence = null === $drug ? null : $this;
        if ($drug->getRecurrence() !== $newRecurrence) {
            $drug->setRecurrence($newRecurrence);
        }

        return $this;
    }
}
