<?php

namespace Rakit\Validation\Tests;

use Rakit\Validation\Rules\AlphaNum;
use PHPUnit\Framework\TestCase;

class AlphaNumTest extends TestCase
{

    public $rule;

    protected function setUp():void
    {
        $this->rule = new AlphaNum;
    }

    public function testValids(): void
    {
        $this->assertTrue($this->rule->check('123'));
        $this->assertTrue($this->rule->check('abc'));
        $this->assertTrue($this->rule->check('123abc'));
        $this->assertTrue($this->rule->check('abc123'));
    }

    public function testInvalids(): void
    {
        $this->assertFalse($this->rule->check('foo 123'));
        $this->assertFalse($this->rule->check('123 foo'));
        $this->assertFalse($this->rule->check(' foo123 '));
    }
}
