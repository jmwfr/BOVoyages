<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoyageRepository")
 */
class Voyage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $destinationVoyage;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAller;

    /**
     * @ORM\Column(type="date")
     */
    private $dateRetour;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombrePersonnes;

    /**
     * @ORM\Column(type="float")
     */
        private $prixVoyage;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Reservation", mappedBy="voyage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $reservation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDestinationVoyage(): ?string
    {
        return $this->destinationVoyage;
    }

    public function setDestinationVoyage(string $destinationVoyage): self
    {
        $this->destinationVoyage = $destinationVoyage;

        return $this;
    }

    public function getDateAller(): ?\DateTimeInterface
    {
        return $this->dateAller;
    }

    public function setDateAller(\DateTimeInterface $dateAller): self
    {
        $this->dateAller = $dateAller;

        return $this;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->dateRetour;
    }

    public function setDateRetour(\DateTimeInterface $dateRetour): self
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    public function getNombrePersonnes(): ?int
    {
        return $this->nombrePersonnes;
    }

    public function setNombrePersonnes(int $nombrePersonnes): self
    {
        $this->nombrePersonnes = $nombrePersonnes;

        return $this;
    }

    public function getPrixVoyage(): ?float
    {
        return $this->prixVoyage;
    }

    public function setPrixVoyage(float $prixVoyage): self
    {
        $this->prixVoyage = $prixVoyage;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): self
    {
        $this->reservation = $reservation;

        // set the owning side of the relation if necessary
        if ($this !== $reservation->getVoyage()) {
            $reservation->setVoyage($this);
        }

        return $this;
    }
}
