<?php

namespace Rakit\Validation\Tests;

use Rakit\Validation\Rules\Integer;
use PHPUnit\Framework\TestCase;

class IntegerTest extends TestCase
{
    public $rule;

    protected function setUp(): void
    {
        $this->rule = new Integer();
    }

    public function testValids(): void
    {
        $this->assertTrue($this->rule->check(0));
        $this->assertTrue($this->rule->check('0'));
        $this->assertTrue($this->rule->check('123'));
        $this->assertTrue($this->rule->check('-123'));
        $this->assertTrue($this->rule->check(123));
        $this->assertTrue($this->rule->check(-123));
    }

    public function testInvalids(): void
    {
        $this->assertFalse($this->rule->check('foo123'));
        $this->assertFalse($this->rule->check('123foo'));
        $this->assertFalse($this->rule->check([123]));
        $this->assertFalse($this->rule->check('123.456'));
        $this->assertFalse($this->rule->check('-123.456'));
    }
}
