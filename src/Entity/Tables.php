<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Controller\Tables\TablesGuestsController;
use App\Controller\Tables\TableStatController;
use App\Repository\TablesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: TablesRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => 'tables:item', 'skip_null_values' => false],
        ),
        new GetCollection(
            normalizationContext: ['groups' => 'tables:list', 'skip_null_values' => false],
            name: 'tables'
        ),
        new GetCollection(
            uriTemplate: '/tables_stats',
            controller: TableStatController::class,
            name: 'tableStat'
        ),
        new GetCollection(
            uriTemplate: '/tables/{id}/guests',
            controller: TablesGuestsController::class,
            name: 'tableGuests'
        ),
        new Patch()
    ],
    paginationEnabled: false
)]
#[ApiFilter(NumericFilter::class, properties: ['num'])]
#[UniqueEntity('num')]
class Tables
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tables:list', 'tables:item', 'guest:item', 'guest:list'])]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    #[Groups(['tables:list', 'tables:item', 'guest:item', 'guest:list'])]
    private ?int $num = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['tables:list', 'tables:item', 'guest:item', 'guest:list'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['tables:list', 'tables:item', 'guest:item', 'guest:list'])]
    private ?int $maxGuests = null;

    #[Groups(['tables:list', 'tables:item', 'guest:item', 'guest:list'])]
    private ?int $guestsDef = 0;

    #[Groups(['tables:list', 'tables:item', 'guest:item', 'guest:list'])]
    private ?int $guestsNow = 0;

    #[ORM\OneToMany(mappedBy: 'tables', targetEntity: GuestList::class, cascade: ['persist'])]
    #[Groups(['tables:list', 'tables:item'])]
    #[SerializedName("guests")]
    private Collection $tables;

    public function __construct()
    {
        $this->tables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): static
    {
        $this->num = $num;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMaxGuests(): ?int
    {
        return $this->maxGuests;
    }

    public function setMaxGuests(?int $maxGuests): static
    {
        $this->maxGuests = $maxGuests;

        return $this;
    }

    public function getGuestsDef(): ?int
    {
        return count($this->tables);
    }

    public function getGuestsNow(): ?int
    {
        $guests = [];
        foreach ($this->tables as $value) {
            if ($value->isIsPresent()) {
                $guests[] = $value;
            }
        }
        return count($guests);
    }

    /**
     * @return Collection<int, GuestList>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    #[Groups(['guest:list', 'guest:item'])]
    public function getGuests(): array
    {
        $guests = [];
        foreach ($this->tables as $value) {
            $guests[] = "/api/guest_lists/" . $value->getId();
        }
        return $guests;
    }

    public function addTable(GuestList $table): static
    {
        if (!$this->tables->contains($table)) {
            $this->tables->add($table);
            $table->setTables($this);
        }

        return $this;
    }

    public function removeTable(GuestList $table): static
    {
        if ($this->tables->removeElement($table)) {
            // set the owning side to null (unless already changed)
            if ($table->getTables() === $this) {
                $table->setTables(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return 'Стол ' . $this->getNum();
    }
}
