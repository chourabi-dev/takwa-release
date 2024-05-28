<?php

namespace App\Entity;

use App\Repository\BusDriverRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BusDriverRepository::class)
 */
class BusDriver
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
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $accessCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\OneToMany(targetEntity=BusTrip::class, mappedBy="driver")
     */
    private $busTrips;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $fcm;

    public function __construct()
    {
        $this->busTrips = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAccessCode(): ?string
    {
        return $this->accessCode;
    }

    public function setAccessCode(string $accessCode): self
    {
        $this->accessCode = $accessCode;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

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
            $busTrip->setDriver($this);
        }

        return $this;
    }

    public function removeBusTrip(BusTrip $busTrip): self
    {
        if ($this->busTrips->removeElement($busTrip)) {
            // set the owning side to null (unless already changed)
            if ($busTrip->getDriver() === $this) {
                $busTrip->setDriver(null);
            }
        }

        return $this;
    }

    public function getFcm(): ?string
    {
        return $this->fcm;
    }

    public function setFcm(?string $fcm): self
    {
        $this->fcm = $fcm;

        return $this;
    }



    function __toString() {
        return $this->fullname;
    }
    
}
