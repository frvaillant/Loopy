<?php

namespace App\Entity;

use App\Repository\PatientRepository;
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
     * @ORM\OneToMany(targetEntity=OverValue::class, mappedBy="patient", orphanRemoval=true)
     */
    private $overValues;

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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAge($date) {
            $age = date('Y') - $date;
            if (date('md') < date('md', strtotime($date))) {
                return $age - 1;
            }
            return $age;
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
}
