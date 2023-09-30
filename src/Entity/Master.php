<?php

namespace App\Entity;

use App\Repository\MasterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MasterRepository::class)]
class Master
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Slave::class, inversedBy: 'masters')]
    private Collection $tool;

    public function __construct()
    {
        $this->tool = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Slave>
     */
    public function getTool(): Collection
    {
        return $this->tool;
    }

    public function addTool(Slave $tool): static
    {
        if (!$this->tool->contains($tool)) {
            $this->tool->add($tool);
        }

        return $this;
    }

    public function removeTool(Slave $tool): static
    {
        $this->tool->removeElement($tool);

        return $this;
    }
    
    public function __toString()
    {
        return $this->getName();
    }
}
