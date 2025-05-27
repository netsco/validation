<?php

namespace Rakit\Validation\Tests;

use Rakit\Validation\Rules\In;
use PHPUnit\Framework\TestCase;

class InTest extends TestCase
{

    public $rule;
    protected function setUp():void
    {
        $this->rule = new In;
    }

    public function testValids(): void
    {
        $this->assertTrue($this->rule->fillParameters([1,2,3])->check(1));
        $this->assertTrue($this->rule->fillParameters(['1', 'bar', '3'])->check('bar'));
    }

    public function testInvalids(): void
    {
        $this->assertFalse($this->rule->fillParameters([1,2,3])->check(4));
    }

    public function testStricts(): void
    {
        // Not strict
        $this->assertTrue($this->rule->fillParameters(['1', '2', '3'])->check(1));
        $this->assertTrue($this->rule->fillParameters(['1', '2', '3'])->check(true));

        // Strict
        $this->rule->strict();
        $this->assertFalse($this->rule->fillParameters(['1', '2', '3'])->check(1));
        $this->assertFalse($this->rule->fillParameters(['1', '2', '3'])->check(1));
    }
}
