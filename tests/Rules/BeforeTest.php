<?php

namespace Rakit\Validation\Tests;

use Exception;
use Rakit\Validation\Rules\Before;
use PHPUnit\Framework\TestCase;
use DateTime;

class BeforeTest extends TestCase
{

    /**
     * @var Before
     */
    protected $validator;

    protected function setUp():void
    {
        $this->validator = new Before();
    }

    /**
     * @dataProvider getValidDates
     */
    public function testOnlyAWellFormedDateCanBeValidated(int|string $date): void
    {
        $this->assertTrue(
            $this->validator->fillParameters(["next week"])->check($date)
        );
    }

    public function getValidDates(): array
    {
        $now = new DateTime();

        return [
            [2016],
            [$now->format("Y-m-d")],
            [$now->format("Y-m-d h:i:s")],
            ["now"],
            ["tomorrow"],
            ["2 years ago"]
        ];
    }

    /**
     * @dataProvider getInvalidDates
     */
    public function testANonWellFormedDateCannotBeValidated(int|string $date): void
    {
        $this->expectException(Exception::class);
        $this->validator->fillParameters(["tomorrow"])->check($date);
    }

    public function getInvalidDates(): array
    {
        $now = new DateTime();

        return [
            [12], //12 instead of 2012
            ["09"], //like '09 instead of 2009
            [$now->format("Y m d")],
            [$now->format("Y m d h:i:s")],
            ["tommorow"], //typo
            ["lasst year"] //typo
        ];
    }

    public function testProvidedDateFailsValidation(): void
    {

        $now = (new DateTime("today"))->format("Y-m-d");
        $today = "today";

        $this->assertFalse(
            $this->validator->fillParameters(['yesterday'])->check($now)
        );

        $this->assertFalse(
            $this->validator->fillParameters(['yesterday'])->check($today)
        );
    }

    public function testUserProvidedParamCannotBeValidatedBecauseItIsInvalid(): void
    {
        $this->expectException(Exception::class);
        $this->validator->fillParameters(["to,morrow"])->check("now");
    }
}
