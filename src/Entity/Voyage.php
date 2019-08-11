<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoyageRepository")
 * @Gedmo\Uploadable(path="img/voyage", filenameGenerator="SHA1", appendNumber=true)
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\UploadableFileName()
     */
    private $image;

    /**
     * @var UploadedFile
     * @Assert\File()
     */
    private $uploadedFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $destinationCountry;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $destinationCity;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

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
 * @ORM\OneToOne(targetEntity="App\Entity\Reservation", mappedBy="voyage", cascade={"persist", "remove"}, orphanRemoval=true)
 * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
 */
    private $reservation;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedFile(): ?UploadedFile
    {
        return $this->uploadedFile;
    }

    /**
     * @param UploadedFile $uploadedFile
     */
    public function setUploadedFile(UploadedFile $uploadedFile): void
    {
        $this->uploadedFile = $uploadedFile;
    }

    public function getDestinationCountry(): ?string
    {
        return $this->destinationCountry;
    }

    public function setDestinationCountry(string $destinationCountry): self
    {
        $this->destinationCountry = $destinationCountry;
        return $this;
    }

    public function getDestinationCity(): ?string
    {
        return $this->destinationCity;
    }

    public function setDestinationCity(string $destinationCity): self
    {
        $this->destinationCity = $destinationCity;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;
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
