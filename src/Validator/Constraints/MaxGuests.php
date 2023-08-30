<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class MaxGuests extends Constraint
{
    public string $message = 'Превышено максимальное количество гостей на данном столе';
}