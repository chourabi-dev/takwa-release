<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TripRepository::class)
 */
class Trip
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
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $tripDaysLong;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $photo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=TripType::class, inversedBy="trips")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=TripReservation::class, mappedBy="trip")
     */
    private $tripReservations;

    public function __construct()
    {
        $this->tripReservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTripDaysLong(): ?int
    {
        return $this->tripDaysLong;
    }

    public function setTripDaysLong(int $tripDaysLong): self
    {
        $this->tripDaysLong = $tripDaysLong;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getType(): ?TripType
    {
        return $this->type;
    }

    public function setType(?TripType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, TripReservation>
     */
    public function getTripReservations(): Collection
    {
        return $this->tripReservations;
    }

    public function addTripReservation(TripReservation $tripReservation): self
    {
        if (!$this->tripReservations->contains($tripReservation)) {
            $this->tripReservations[] = $tripReservation;
            $tripReservation->setTrip($this);
        }

        return $this;
    }

    public function removeTripReservation(TripReservation $tripReservation): self
    {
        if ($this->tripReservations->removeElement($tripReservation)) {
            // set the owning side to null (unless already changed)
            if ($tripReservation->getTrip() === $this) {
                $tripReservation->setTrip(null);
            }
        }

        return $this;
    }




    function __toString() {
        return $this->title;
    }
}
