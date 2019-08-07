<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoyageurRepository")
 */
class Voyageur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nomVoyageur;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $prenomVoyageur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservation", inversedBy="voyageurs")
     */
    private $reservation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVoyageur(): ?string
    {
        return $this->nomVoyageur;
    }

    public function setNomVoyageur(string $nomVoyageur): self
    {
        $this->nomVoyageur = $nomVoyageur;

        return $this;
    }

    public function getPrenomVoyageur(): ?string
    {
        return $this->prenomVoyageur;
    }

    public function setPrenomVoyageur(string $prenomVoyageur): self
    {
        $this->prenomVoyageur = $prenomVoyageur;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }
}
