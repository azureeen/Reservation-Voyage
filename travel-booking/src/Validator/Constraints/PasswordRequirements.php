<?php

// src/Validator/Constraints/PasswordRequirements.php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PasswordRequirements extends Constraint
{
    public $message = 'Password must be at least 12 characters long and include at least one uppercase letter, one number, and one special character.';
}
