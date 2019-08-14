<?php

namespace App\Validator\Constraints;

use libphonenumber\PhoneNumberUtil;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Tests\Fixtures\ConstraintAValidator;

class PhoneValidator extends ConstraintAValidator
{
    public function validate($value, Constraint $constraint)
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();

        try {
            $phoneNumberObject = $phoneNumberUtil->parse($value, 'FR');

            if($phoneNumberUtil->isValidNumber($phoneNumberObject) === false) {
                return $this
                    ->context
                    ->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
        catch(\Exception $e) {
            return $this
                ->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}