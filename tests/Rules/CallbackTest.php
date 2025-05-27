<?php

namespace Rakit\Validation\Tests;

use Rakit\Validation\Rules\Callback;
use PHPUnit\Framework\TestCase;

class CallbackTest extends TestCase
{

    public $rule;

    protected function setUp():void
    {
        $this->rule = new Callback;
        $this->rule->setCallback(fn($value): bool => is_numeric($value) && $value % 2 === 0);
    }

    public function testValids(): void
    {
        $this->assertTrue($this->rule->check(2));
        $this->assertTrue($this->rule->check('4'));
        $this->assertTrue($this->rule->check("1000"));
    }

    public function testInvalids(): void
    {
        $this->assertFalse($this->rule->check(1));
        $this->assertFalse($this->rule->check('abc12'));
        $this->assertFalse($this->rule->check("12abc"));
    }
}
