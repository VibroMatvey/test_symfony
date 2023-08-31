<?php

namespace App\Validator\Constraints;

use App\Entity\GuestList;
use App\Repository\GuestListRepository;
use App\Repository\TablesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class MaxGuestsValidator extends ConstraintValidator
{
    public function __construct(private readonly GuestListRepository $guestListRepository, private readonly TablesRepository $tablesRepository)
    {
    }
    public function validate($value, Constraint $constraint): void
    {
        $table = $this->tablesRepository->find($value);
        if ($table->getMaxGuests()) {
            if ($this->context->getObject()->getId()) {
                $guest = $this->guestListRepository->find($this->context->getObject()->getId());
                $table->addTable($guest);
                if ($table->getMaxGuests() < count($table->getTables())) {
                    $this->context->buildViolation($constraint->message)->addViolation();
                }
            } else {
                if ($table->getMaxGuests() == count($table->getTables())) {
                    $this->context->buildViolation($constraint->message)->addViolation();
                }
            }
        }
    }
}