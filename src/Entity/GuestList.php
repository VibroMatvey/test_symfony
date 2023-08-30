<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\GuestListRepository;
use App\Validator\Constraints\MaxGuests;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GuestListRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'guest:item', 'skip_null_values' => false]),
        new GetCollection(normalizationContext: ['groups' => 'guest:list', 'skip_null_values' => false]),
        new Patch()
    ],
    paginationEnabled: false,

),
ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
#[ApiFilter(BooleanFilter::class, properties: ['isPresent'])]
class GuestList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['guest:list', 'guest:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['guest:list', 'guest:item'])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['guest:list', 'guest:item'])]
    private ?bool $isPresent = null;

    #[ORM\ManyToOne(inversedBy: 'tables')]
    #[MaxGuests]
    #[Groups(['guest:list', 'guest:item'])]
    private ?Tables $tables = null;

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

    public function isIsPresent(): ?bool
    {
        return $this->isPresent;
    }

    public function setIsPresent(?bool $isPresent): static
    {
        $this->isPresent = $isPresent;

        return $this;
    }

    public function getTables(): ?Tables
    {
        return $this->tables;
    }

    public function setTables(?Tables $tables): static
    {
        $this->tables = $tables;

        return $this;
    }
}
