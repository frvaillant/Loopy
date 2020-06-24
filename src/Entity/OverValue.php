<?php

namespace App\Entity;

use App\Repository\OverValueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OverValueRepository::class)
 */
class OverValue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="overValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasValue;

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

    public function getHasValue(): ?bool
    {
        return $this->hasValue;
    }

    public function setHasValue(bool $hasValue): self
    {
        $this->hasValue = $hasValue;

        return $this;
    }
}
