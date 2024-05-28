<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity=EventReservation::class, mappedBy="user")
     */
    private $eventReservations;

    /**
     * @ORM\OneToMany(targetEntity=RoomReservation::class, mappedBy="user")
     */
    private $roomReservations;

    /**
     * @ORM\OneToMany(targetEntity=BusReservations::class, mappedBy="client")
     */
    private $busReservations;

    /**
     * @ORM\OneToMany(targetEntity=TripReservation::class, mappedBy="user")
     */
    private $tripReservations;

    public function __construct()
    {
        $this->eventReservations = new ArrayCollection();
        $this->roomReservations = new ArrayCollection();
        $this->busReservations = new ArrayCollection();
        $this->tripReservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(?string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, EventReservation>
     */
    public function getEventReservations(): Collection
    {
        return $this->eventReservations;
    }

    public function addEventReservation(EventReservation $eventReservation): self
    {
        if (!$this->eventReservations->contains($eventReservation)) {
            $this->eventReservations[] = $eventReservation;
            $eventReservation->setUser($this);
        }

        return $this;
    }

    public function removeEventReservation(EventReservation $eventReservation): self
    {
        if ($this->eventReservations->removeElement($eventReservation)) {
            // set the owning side to null (unless already changed)
            if ($eventReservation->getUser() === $this) {
                $eventReservation->setUser(null);
            }
        }

        return $this;
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
            $roomReservation->setUser($this);
        }

        return $this;
    }

    public function removeRoomReservation(RoomReservation $roomReservation): self
    {
        if ($this->roomReservations->removeElement($roomReservation)) {
            // set the owning side to null (unless already changed)
            if ($roomReservation->getUser() === $this) {
                $roomReservation->setUser(null);
            }
        }

        return $this;
    }


    function __toString(){
        return "".$this->fullname;        
    }

    /**
     * @return Collection<int, BusReservations>
     */
    public function getBusReservations(): Collection
    {
        return $this->busReservations;
    }

    public function addBusReservation(BusReservations $busReservation): self
    {
        if (!$this->busReservations->contains($busReservation)) {
            $this->busReservations[] = $busReservation;
            $busReservation->setClient($this);
        }

        return $this;
    }

    public function removeBusReservation(BusReservations $busReservation): self
    {
        if ($this->busReservations->removeElement($busReservation)) {
            // set the owning side to null (unless already changed)
            if ($busReservation->getClient() === $this) {
                $busReservation->setClient(null);
            }
        }

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
            $tripReservation->setUser($this);
        }

        return $this;
    }

    public function removeTripReservation(TripReservation $tripReservation): self
    {
        if ($this->tripReservations->removeElement($tripReservation)) {
            // set the owning side to null (unless already changed)
            if ($tripReservation->getUser() === $this) {
                $tripReservation->setUser(null);
            }
        }

        return $this;
    }

}
