<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AskRepository")
 */
class Ask
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $objectif;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="asks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Mission", inversedBy="asks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mission_id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Beneficiaire", inversedBy="asks")
     */
    private $benificiaire_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="asks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="ask_id", orphanRemoval=true)
     */
    private $answers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->benificiaire_id = new ArrayCollection();
        $this->answers = new ArrayCollection();
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getObjectif(): ?string
    {
        return $this->objectif;
    }

    public function setObjectif(string $objectif): self
    {
        $this->objectif = $objectif;

        return $this;
    }

    public function getCityId(): ?City
    {
        return $this->city_id;
    }

    public function setCityId(?City $city_id): self
    {
        $this->city_id = $city_id;

        return $this;
    }

    public function getMissionId(): ?Mission
    {
        return $this->mission_id;
    }

    public function setMissionId(?Mission $mission_id): self
    {
        $this->mission_id = $mission_id;

        return $this;
    }

    /**
     * @return Collection|Beneficiaire[]
     */
    public function getBenificiaireId(): Collection
    {
        return $this->benificiaire_id;
    }

    public function addBenificiaireId(Beneficiaire $benificiaireId): self
    {
        if (!$this->benificiaire_id->contains($benificiaireId)) {
            $this->benificiaire_id[] = $benificiaireId;
        }

        return $this;
    }

    public function removeBenificiaireId(Beneficiaire $benificiaireId): self
    {
        if ($this->benificiaire_id->contains($benificiaireId)) {
            $this->benificiaire_id->removeElement($benificiaireId);
        }

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setAskId($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getAskId() === $this) {
                $answer->setAskId(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
