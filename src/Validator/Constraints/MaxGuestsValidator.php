<?php

namespace App\Validator\Constraints;

use App\Repository\GuestListRepository;
use App\Repository\TablesRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class MaxGuestsValidator extends ConstraintValidator
{
    public function __construct(private readonly GuestListRepository $guestListRepository, private readonly TablesRepository $tablesRepository)
    {
    }
    public function validate($value, Constraint $constraint): void
    {
        $guests = $this->guestListRepository->findBy(['tables' => $value]);
        $maxGuest = $this->tablesRepository->find($value)->getMaxGuests();
        if (count($guests) === $maxGuest) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}