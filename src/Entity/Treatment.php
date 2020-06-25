<?php

namespace App\Entity;

use App\Repository\TreatmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TreatmentRepository::class)
 */
class Treatment
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
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="treatment", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Recurrence::class, mappedBy="treatment", orphanRemoval=true)
     */
    private $recurrences;


    public function __construct()
    {
        $this->recurrence = new ArrayCollection();
        $this->recurrences = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        //$newTreatment = null === $user ? null : $this;
        //if ($user->getTreatment() !== $newTreatment) {
        //   $user->setTreatment($newTreatment);
        //}

        return $this;
    }

    /**
     * @return Collection|Recurrence[]
     */
    public function getRecurrences(): Collection
    {
        return $this->recurrences;
    }

    public function addRecurrence(Recurrence $recurrence): self
    {
        if (!$this->recurrences->contains($recurrence)) {
            $this->recurrences[] = $recurrence;
            $recurrence->setTreatment($this);
        }

        return $this;
    }

    public function removeRecurrence(Recurrence $recurrence): self
    {
        if ($this->recurrences->contains($recurrence)) {
            $this->recurrences->removeElement($recurrence);
            // set the owning side to null (unless already changed)
            if ($recurrence->getTreatment() === $this) {
                $recurrence->setTreatment(null);
            }
        }

        return $this;
    }
}
