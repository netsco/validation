<?php

namespace Rakit\Validation\Tests;

use Rakit\Validation\Rules\Required;
use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    /**
     * @var Required
     */
    protected $validator;

    protected function setUp(): void
    {
        $this->validator = new Required();
    }

    /**
     * @dataProvider validValuesProvider
     */
    public function testValidValues($value): void
    {
        $this->assertTrue(
            $this->validator->check($value)
        );
    }

    public function validValuesProvider(): array
    {
        return [
            ['some string'],
            [123],
            [0],
            [false],
            [[1, 2, 3]],
        ];
    }

    /**
     * @dataProvider invalidValuesProvider
     */
    public function testInvalidValues($value): void
    {
        $this->assertFalse(
            $this->validator->check($value)
        );
    }

    public function invalidValuesProvider(): array
    {
        return [
            [''],
            [null],
            [[]],
        ];
    }
}
