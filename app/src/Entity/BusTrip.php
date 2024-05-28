<?php

namespace App\Entity;

use App\Repository\BusTripRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BusTripRepository::class)
 */
class BusTrip
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=BusDriver::class, inversedBy="busTrips")
     */
    private $driver;

    /**
     * @ORM\ManyToOne(targetEntity=BusReservations::class, inversedBy="busTrips")
     */
    private $trip;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDriver(): ?BusDriver
    {
        return $this->driver;
    }

    public function setDriver(?BusDriver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function getTrip(): ?BusReservations
    {
        return $this->trip;
    }

    public function setTrip(?BusReservations $trip): self
    {
        $this->trip = $trip;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
