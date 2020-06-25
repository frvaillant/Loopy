<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use App\Service\DateManager;
use App\Service\NumberManager;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Patient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class, inversedBy="patients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $doctor;

    /**
     * @ORM\Column(type="integer")
     */
    private $limitUp;

    /**
     * @ORM\Column(type="integer")
     */
    private $limitDown;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Award::class, mappedBy="patient", orphanRemoval=true)
     */
    private $awards;

    /**
     * @ORM\OneToMany(targetEntity=Data::class, mappedBy="patient", orphanRemoval=true)
     */
    private $data;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=OverValue::class, mappedBy="patient", orphanRemoval=true)
     */
    private $overValues;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $dadSurname;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $dadFirstName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $dadPhoneNumber;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $momSurname;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $momFirstName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $momPhoneNumber;

    public function __construct()
    {
        $this->awards = new ArrayCollection();
        $this->data = new ArrayCollection();
        $this->overValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBirthday(): ?DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAge(): int
    {
        $interval = DateManager::dateIntervalBetweenNowAnd($this->getBirthday());
        return $interval->y;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getLimitUp(): ?int
    {
        return $this->limitUp;
    }

    public function setLimitUp(int $limitUp): self
    {
        $this->limitUp = $limitUp;

        return $this;
    }

    public function getLimitDown(): ?int
    {
        return $this->limitDown;
    }

    public function setLimitDown(int $limitDown): self
    {
        $this->limitDown = $limitDown;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist()
     * @return $this
     */
    public function setCreatedAt(): self
    {
        $this->createdAt = new DateTime();

        return $this;
    }

    /**
     * @return Collection|Award[]
     */
    public function getAwards(): Collection
    {
        return $this->awards;
    }

    public function addAward(Award $award): self
    {
        if (!$this->awards->contains($award)) {
            $this->awards[] = $award;
            $award->setPatient($this);
        }

        return $this;
    }

    public function removeAward(Award $award): self
    {
        if ($this->awards->contains($award)) {
            $this->awards->removeElement($award);
            // set the owning side to null (unless already changed)
            if ($award->getPatient() === $this) {
                $award->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Data[]
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    public function addData(Data $data): self
    {
        if (!$this->data->contains($data)) {
            $this->data[] = $data;
            $data->setPatient($this);
        }

        return $this;
    }

    public function removeData(Data $data): self
    {
        if ($this->data->contains($data)) {
            $this->data->removeElement($data);
            // set the owning side to null (unless already changed)
            if ($data->getPatient() === $this) {
                $data->setPatient(null);
            }
        }

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

    /**
     * @return Collection|OverValue[]
     */
    public function getOverValues(): Collection
    {
        return $this->overValues;
    }

    public function addOverValue(OverValue $overValue): self
    {
        if (!$this->overValues->contains($overValue)) {
            $this->overValues[] = $overValue;
            $overValue->setPatient($this);
        }

        return $this;
    }

    public function removeOverValue(OverValue $overValue): self
    {
        if ($this->overValues->contains($overValue)) {
            $this->overValues->removeElement($overValue);
            // set the owning side to null (unless already changed)
            if ($overValue->getPatient() === $this) {
                $overValue->setPatient(null);
            }
        }

        return $this;
    }

    public function getDadSurname(): ?string
    {
        return $this->dadSurname;
    }

    public function setDadSurname(?string $dadSurname): self
    {
        $this->dadSurname = $dadSurname;

        return $this;
    }

    public function getDadFirstName(): ?string
    {
        return $this->dadFirstName;
    }

    public function setDadFirstName(?string $dadFirstName): self
    {
        $this->dadFirstName = $dadFirstName;

        return $this;
    }

    public function getDadFullName(): string
    {
        return 'M. ' . $this->dadFirstName . ' ' . strtoupper($this->dadSurname);
    }

    public function getDadPhoneNumber(): ?string
    {
        return $this->dadPhoneNumber;
    }

    public function getDadFormattedPhoneNumber(): string
    {
        return NumberManager::addPointToPhoneNumber($this->getDadPhoneNumber());
    }

    public function setDadPhoneNumber(?string $dadPhoneNumber): self
    {
        $this->dadPhoneNumber = $dadPhoneNumber;

        return $this;
    }

    public function getMomSurname(): ?string
    {
        return $this->momSurname;
    }

    public function setMomSurname(?string $momSurname): self
    {
        $this->momSurname = $momSurname;

        return $this;
    }

    public function getMomFirstName(): ?string
    {
        return $this->momFirstName;
    }

    public function setMomFirstName(?string $momFirstName): self
    {
        $this->momFirstName = $momFirstName;

        return $this;
    }

    public function getMomFullName(): string
    {
        return 'Mme. ' . $this->momFirstName . ' ' . strtoupper($this->momSurname);
    }

    public function getMomPhoneNumber(): ?string
    {
        return $this->momPhoneNumber;
    }

    public function getMomFormattedPhoneNumber(): string
    {
        return NumberManager::addPointToPhoneNumber($this->getMomPhoneNumber());
    }

    public function setMomPhoneNumber(?string $momPhoneNumber): self
    {
        $this->momPhoneNumber = $momPhoneNumber;

        return $this;
    }
}
