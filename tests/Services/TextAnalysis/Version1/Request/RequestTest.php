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

namespace App\Tests\Services\TextAnalysis\Version1\Request;

use App\Services\TextAnalysis\Analyze\Version1\Request\Request as RequestModel;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestTest extends WebTestCase
{
    private ValidatorInterface $validator;

    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $this->validator = $container->get(ValidatorInterface::class);
        $this->serializer = $container->get(SerializerInterface::class);

        parent::setUp();
    }

    public function testRequestModelSuccess(): void
    {
        $requestModel = $this->serializer->deserialize($this->validJson(), RequestModel::class, 'json');
        $violations = $this->validator->validate($requestModel);

        self::assertCount(0, $violations);
    }

    public function testRequestModelInvalid(): void
    {
        $requestModel = $this->serializer->deserialize($this->invalidJson(), RequestModel::class, 'json');
        $violations = $this->validator->validate($requestModel);

        self::assertCount(2, $violations);

        $firstViolation = 0;
        foreach ($violations ?? [] as $violation) {
            if (0 === $firstViolation) {
                self::assertSame('The provided string contains not enough words.', $violation->getMessage());
            }
            $firstViolation++;
        }
    }

    private function validJson(): string
    {
        return '{"text": "This text is valid", "analysis": "full"}';
    }

    private function invalidJson(): string
    {
        return '{"text": "This"}';
    }
}
