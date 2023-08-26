<?php

namespace App\Controller\GuestList;

use App\Entity\GuestList;
use App\Repository\GuestListRepository;
use App\Repository\TablesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetTableGuestsController extends AbstractController
{
    public function __construct(private TablesRepository $repository)
    {
    }

    public function __invoke(): \App\Entity\Tables
    {
        return $this->repository->findOneBy(['id' => '/api/tables/2']);
    }
}