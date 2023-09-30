<?php

namespace App\Entity;

use App\Repository\SlaveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SlaveRepository::class)]
class Slave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tool = null;

    #[ORM\ManyToMany(targetEntity: Master::class, mappedBy: 'tool', cascade: ['persist'])]
    private Collection $masters;

    public function __construct()
    {
        $this->masters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTool(): ?string
    {
        return $this->tool;
    }

    public function setTool(string $tool): static
    {
        $this->tool = $tool;

        return $this;
    }

    /**
     * @return Collection<int, Master>
     */
    public function getMasters(): Collection
    {
        return $this->masters;
    }

    public function addMaster(Master $master): static
    {
        if (!$this->masters->contains($master)) {
            $this->masters->add($master);
            $master->addTool($this);
        }

        return $this;
    }

    public function removeMaster(Master $master): static
    {
        if ($this->masters->removeElement($master)) {
            $master->removeTool($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getTool();
    }
}
