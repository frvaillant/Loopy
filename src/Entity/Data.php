<?php

namespace App\Entity;

use App\Repository\DataRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DataRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Data
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="data")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity=DataCategory::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $dataCategory;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\Column(type="datetime")
     */
    private $addedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasEaten = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDataCategory(): ?DataCategory
    {
        return $this->dataCategory;
    }

    public function setDataCategory(?DataCategory $dataCategory): self
    {
        $this->dataCategory = $dataCategory;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    /**
     * @param DateTime $dateTime
     * @return $this
     */
    public function setAddedAt(DateTime $dateTime = null): self
    {
        $this->addedAt = new DateTime();
        if ($dateTime) {
            $this->addedAt = $dateTime;
        }

        return $this;
    }

    public function getHasEaten(): ?bool
    {
        return $this->hasEaten;
    }

    public function setHasEaten(bool $hasEaten): self
    {
        $this->hasEaten = $hasEaten;

        return $this;
    }
}
