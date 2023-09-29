<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MoviesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MoviesRepository::class)]
class Movies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Merci de renseigner ce champ")]
    private ?string $title = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'movies', cascade: ['persist', 'remove'])]
    private Collection $viewers;

    public function __construct()
    {
        $this->viewers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getViewers(): Collection
    {
        return $this->viewers;
    }

    public function addViewer(User $viewer): static
    {
        if (!$this->viewers->contains($viewer)) {
            $this->viewers->add($viewer);
        }

        return $this;
    }

    public function removeViewer(User $viewer): static
    {
        $this->viewers->removeElement($viewer);

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
