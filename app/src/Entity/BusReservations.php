<?php

namespace App\Entity;

use App\Repository\BusReservationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BusReservationsRepository::class)
 */
class BusReservations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $places;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $destination;

    /**
     * @ORM\Column(type="datetime")
     */
    private $checkin;

    /**
     * @ORM\Column(type="datetime")
     */
    private $checkout;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contactName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="busReservations")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=BusTrip::class, mappedBy="trip")
     */
    private $busTrips;

    public function __construct()
    {
        $this->busTrips = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getCheckin(): ?\DateTimeInterface
    {
        return $this->checkin;
    }

    public function setCheckin(\DateTimeInterface $checkin): self
    {
        $this->checkin = $checkin;

        return $this;
    }

    public function getCheckout(): ?\DateTimeInterface
    {
        return $this->checkout;
    }

    public function setCheckout(\DateTimeInterface $checkout): self
    {
        $this->checkout = $checkout;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(string $contactName): self
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, BusTrip>
     */
    public function getBusTrips(): Collection
    {
        return $this->busTrips;
    }

    public function addBusTrip(BusTrip $busTrip): self
    {
        if (!$this->busTrips->contains($busTrip)) {
            $this->busTrips[] = $busTrip;
            $busTrip->setTrip($this);
        }

        return $this;
    }

    public function removeBusTrip(BusTrip $busTrip): self
    {
        if ($this->busTrips->removeElement($busTrip)) {
            // set the owning side to null (unless already changed)
            if ($busTrip->getTrip() === $this) {
                $busTrip->setTrip(null);
            }
        }

        return $this;
    }



    function __toString() {
        return $this->destination;
    }
    
}
