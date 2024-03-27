<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[HasLifecycleCallbacks]
#[UniqueEntity(
    fields: ['title', 'slug'],
    errorPath: 'title',
    message: 'The Title and the Slug must be unique.'
)]

class Movie
{
    use \App\Traits\LifecycleTrackerTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, length: 255)]
    private ?string $description;

    #[ORM\Column(length: 255)]
    private ?\DateTimeInterface $releaseYear;

    #[ORM\Column(length : 255)]
    private ?string $imagePath;

    #[ORM\Column(length: 255)]
    private $actors;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $slug;

    public function __construct()
    {
        $this->actors = new ArrayCollection();
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

    public function getReleaseYear(): ?\DateTimeInterface
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(\DateTimeInterface $releaseYear): static
    {
        $this->releaseYear = $releaseYear;

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

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * @return Collection|Actor[]
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors[] = $actor;
        }

        return $this;
    }

    public function removeActor(Actor $actor): self
    {
        $this->actors->removeElement($actor);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    //functionalité de la base
    public function setSlug(string $slug): static
    {
        $slugger = new AsciiSlugger;
        $this->slug = $slugger->slug($slug);
        unset($slugger);
        return $this;
    }

    //automatic, 同时修改title时也同时修改slug
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setSlugValue(): void
    {
        $slugger = new AsciiSlugger;
        $this->slug = $slugger->slug($this->title);
        unset($slugger); //以防不会自动销毁 détruit automatic
    }
}
