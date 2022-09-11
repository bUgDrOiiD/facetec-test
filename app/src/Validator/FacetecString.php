<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class FacetecString extends Constraint
{
    public $message = 'The string "{{ value }}" has to contain either the text "Face" (case sensitive) or the text "Tec" (case insensitive).';
}