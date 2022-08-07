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

namespace App\Tests\Validator\Properties;

use App\Validator\Properties\WordCount;
use App\Validator\Properties\WordCountValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class WordCountValidatorCustomTest extends TestCase
{
    public function testInvalidConstraint(): void
    {
        $constraint = new WordCountValidator();

        $this->expectException(UnexpectedTypeException::class);
        $constraint->validate('test', new NotNull());
    }

    public function testInvalidType(): void
    {
        $constraint = new WordCountValidator();

        $this->expectException(UnexpectedValueException::class);
        $constraint->validate(1, new WordCount(2));
    }

    public function testNullValue(): void
    {
        $constraint = new WordCountValidator();

        self::assertNull($constraint->validate(null, new WordCount(2)));
    }
}
