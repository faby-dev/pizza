<?php

namespace App\Entity;

use App\Repository\CommandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandRepository::class)]
class Command
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'Commands')]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'command', targetEntity: Pizza::class)]
    private Collection $Pizzas;

    public function __construct()
    {
        $this->Pizzas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Pizza>
     */
    public function getPizzas(): Collection
    {
        return $this->Pizzas;
    }

    public function addPizza(Pizza $pizza): self
    {
        if (!$this->Pizzas->contains($pizza)) {
            $this->Pizzas->add($pizza);
            $pizza->setCommand($this);
        }

        return $this;
    }

    public function removePizza(Pizza $pizza): self
    {
        if ($this->Pizzas->removeElement($pizza)) {
            // set the owning side to null (unless already changed)
            if ($pizza->getCommand() === $this) {
                $pizza->setCommand(null);
            }
        }

        return $this;
    }
}
