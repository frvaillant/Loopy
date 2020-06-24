<?php

namespace App\Entity;

use App\Repository\AwardRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AwardRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Award
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="awards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity=Badge::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $badge;

    /**
     * @ORM\Column(type="datetime")
     */
    private $obtainedAt;

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

    public function getBadge(): ?Badge
    {
        return $this->badge;
    }

    public function setBadge(?Badge $badge): self
    {
        $this->badge = $badge;

        return $this;
    }

    public function getObtainedAt(): ?\DateTimeInterface
    {
        return $this->obtainedAt;
    }

    /**
     * @ORM\PrePersist()
     * @return $this
     */
    public function setObtainedAt(): self
    {
        $this->obtainedAt = new DateTime();

        return $this;
    }
}
