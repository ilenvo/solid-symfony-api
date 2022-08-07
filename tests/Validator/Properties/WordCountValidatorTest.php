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
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class WordCountValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator()
    {
        return new WordCountValidator();
    }

    public function testNullIsValid(): void
    {
        $this->validator->validate(null, new WordCount(2));
        $this->assertNoViolation();
    }

    public function testBlankIsValid(): void
    {
        $this->validator->validate('', new WordCount(2));
        $this->assertNoViolation();
    }

    public function testStringIsValid(): void
    {
        $this->validator->validate('one two three', new WordCount(2));
        $this->assertNoViolation();
    }

    public function testToLessWords(): void
    {
        $this->validator->validate('one', new WordCount(2));
        $this->buildViolation('The provided string contains not enough words.')
            ->assertRaised();
    }
}
