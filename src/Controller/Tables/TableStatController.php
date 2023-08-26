<?php

namespace App\Controller\Tables;

use App\Entity\Tables;
use App\Repository\TablesRepository;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class TableStatController
{
    private TablesRepository $tablesRepository;

    public function __construct(TablesRepository $tablesRepository)
    {
        $this->tablesRepository = $tablesRepository;
    }
    public function __invoke(): array
    {
        $tablesStat = [];
        $tables = $this->tablesRepository->findAll();
        foreach ($tables as $table) {
            $usersCount = 0;
            $guests = $table->getTables();
            foreach ($guests as $guest) {
                if ($guest->isIsPresent()) {
                    $usersCount++;
                }
            }
            $tablesStat[] = [
                'id' => $table->getId(),
                'num' => $table->getNum(),
                'maxGuests' => $table->getMaxGuests(),
                'guestIsPresent' => $usersCount
            ];
        }
        return $tablesStat;
    }
}