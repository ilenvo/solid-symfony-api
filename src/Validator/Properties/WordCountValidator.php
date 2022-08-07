<?php

declare(strict_types=1);

/**
 * This project shows, how you can build a SOLID and restful API with symfony.
 *
 * @copyright  Stefan H.G. Buchhofer
 * @link       www.ilenvo.com
 * @email      ilenvo@me.com
 * @year       2022
 */

namespace App\Validator\Properties;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class WordCountValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof WordCount) {
            throw new UnexpectedTypeException($constraint, WordCount::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if ($this->countWords($value) <= $constraint->wordCount) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    /**
     * this word count function is not perfect and only for demonstration
     * the PHP function str_word_count is even worse for utf-8
     */
    private function countWords(string $text): int
    {
        return count(preg_split('~[^\p{L}\p{N}\'\-]+~u', $text));
    }
}
