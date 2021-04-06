<?php

namespace App\Entity;

use App\Repository\PrefectureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrefectureRepository::class)
 */
class Prefecture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\OneToMany(targetEntity=Association::class, mappedBy="prefecture")
     */
    private $Prefecture;

    public function __construct()
    {
        $this->Prefecture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return Collection|Association[]
     */
    public function getPrefecture(): Collection
    {
        return $this->Prefecture;
    }

    public function addPrefecture(Association $prefecture): self
    {
        if (!$this->Prefecture->contains($prefecture)) {
            $this->Prefecture[] = $prefecture;
            $prefecture->setPrefecture($this);
        }

        return $this;
    }

    public function removePrefecture(Association $prefecture): self
    {
        if ($this->Prefecture->removeElement($prefecture)) {
            // set the owning side to null (unless already changed)
            if ($prefecture->getPrefecture() === $this) {
                $prefecture->setPrefecture(null);
            }
        }

        return $this;
    }
}
