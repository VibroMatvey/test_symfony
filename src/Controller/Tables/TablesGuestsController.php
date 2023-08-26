<?php

namespace App\Controller\Tables;

use App\Entity\Tables;
use App\Repository\GuestListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class TablesGuestsController extends AbstractController
{
    private GuestListRepository $guestListRepository;

    public function __construct(GuestListRepository $guestListRepository)
    {
        $this->guestListRepository = $guestListRepository;
    }

    public function __invoke(Tables $tables): array
    {
        $result = [];
        $guests = $this->guestListRepository->findTableGuests($tables->getId());
        foreach ($guests as $guest) {
            $result[] = [
                'id' => $guest->getId(),
                'name' => $guest->getName(),
                'isPresent' => $guest->isIsPresent(),
                'tables' => $guest->getTables()
            ];
        }
        return $result;
    }
}