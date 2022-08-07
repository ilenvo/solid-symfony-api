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

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class WordCount extends Constraint
{
    public string $message = 'The provided string contains not enough words.';

    public int $wordCount;

    #[HasNamedArguments]
    public function __construct(int $wordCount, array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->wordCount = $wordCount;
    }

    public function validatedBy(): string
    {
        return static::class . 'Validator';
    }
}
