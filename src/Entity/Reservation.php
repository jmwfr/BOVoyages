<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $numCB;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="reservations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Voyage", mappedBy="reservation", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $voyage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Voyageur", mappedBy="reservation", cascade={"persist", "remove"})
     */
    private $voyageurs;

    public function __construct()
    {
        $this->voyageurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCB(): ?string
    {
        return $this->numCB;
    }

    public function setNumCB(string $numCB): self
    {
        $this->numCB = $numCB;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getVoyage(): ?voyage
    {
        return $this->voyage;
    }

    public function setVoyage(voyage $voyage): self
    {
        $this->voyage = $voyage;

        return $this;
    }

    /**
     * @return Collection|Voyageur[]
     */
    public function getVoyageurs(): Collection
    {
        return $this->voyageurs;
    }

    public function addVoyageur(Voyageur $voyageur): self
    {
        if (!$this->voyageurs->contains($voyageur)) {
            $this->voyageurs[] = $voyageur;
            $voyageur->setReservation($this);
        }

        return $this;
    }

    public function removeVoyageur(Voyageur $voyageur): self
    {
        if ($this->voyageurs->contains($voyageur)) {
            $this->voyageurs->removeElement($voyageur);
            // set the owning side to null (unless already changed)
            if ($voyageur->getReservation() === $this) {
                $voyageur->setReservation(null);
            }
        }

        return $this;
    }
}
