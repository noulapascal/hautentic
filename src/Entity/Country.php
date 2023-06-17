<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: RegionOrState::class)]
    private Collection $regionOrStates;

    public function __construct()
    {
        $this->regionOrStates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * @return Collection<int, RegionOrState>
     */
    public function getRegionOrStates(): Collection
    {
        return $this->regionOrStates;
    }

    public function addRegionOrState(RegionOrState $regionOrState): self
    {
        if (!$this->regionOrStates->contains($regionOrState)) {
            $this->regionOrStates->add($regionOrState);
            $regionOrState->setCountry($this);
        }

        return $this;
    }

    public function removeRegionOrState(RegionOrState $regionOrState): self
    {
        if ($this->regionOrStates->removeElement($regionOrState)) {
            // set the owning side to null (unless already changed)
            if ($regionOrState->getCountry() === $this) {
                $regionOrState->setCountry(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->name;
    }
}
