<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */

class Room
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $address;

    /**
     * @ORM\Column(type="float")
     */
    private $lng;

    /**
     * @ORM\Column(type="float")
     */
    private $lat;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="rooms")
     */
    private $region;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=RoomPhoto::class, mappedBy="room")
     */
    private $roomPhotos;

    /**
     * @ORM\OneToMany(targetEntity=RoomReservation::class, mappedBy="room")
     */
    private $roomReservations;

    public function __construct()
    {
        $this->roomPhotos = new ArrayCollection();
        $this->roomReservations = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, RoomPhoto>
     */
    public function getRoomPhotos(): Collection
    {
        return $this->roomPhotos;
    }

    public function addRoomPhoto(RoomPhoto $roomPhoto): self
    {
        if (!$this->roomPhotos->contains($roomPhoto)) {
            $this->roomPhotos[] = $roomPhoto;
            $roomPhoto->setRoom($this);
        }

        return $this;
    }

    public function removeRoomPhoto(RoomPhoto $roomPhoto): self
    {
        if ($this->roomPhotos->removeElement($roomPhoto)) {
            // set the owning side to null (unless already changed)
            if ($roomPhoto->getRoom() === $this) {
                $roomPhoto->setRoom(null);
            }
        }

        return $this;
    }



    function __toString() {
        return $this->title;
    }

    /**
     * @return Collection<int, RoomReservation>
     */
    public function getRoomReservations(): Collection
    {
        return $this->roomReservations;
    }

    public function addRoomReservation(RoomReservation $roomReservation): self
    {
        if (!$this->roomReservations->contains($roomReservation)) {
            $this->roomReservations[] = $roomReservation;
            $roomReservation->setRoom($this);
        }

        return $this;
    }

    public function removeRoomReservation(RoomReservation $roomReservation): self
    {
        if ($this->roomReservations->removeElement($roomReservation)) {
            // set the owning side to null (unless already changed)
            if ($roomReservation->getRoom() === $this) {
                $roomReservation->setRoom(null);
            }
        }

        return $this;
    }
}
