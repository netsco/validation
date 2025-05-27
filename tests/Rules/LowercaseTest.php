<?php

namespace Rakit\Validation\Tests;

use Rakit\Validation\Rules\Lowercase;
use PHPUnit\Framework\TestCase;

class LowercaseTest extends TestCase
{

    public $rule;
    protected function setUp():void
    {
        $this->rule = new Lowercase;
    }

    public function testValids(): void
    {
        $this->assertTrue($this->rule->check('username'));
        $this->assertTrue($this->rule->check('full name'));
        $this->assertTrue($this->rule->check('full_name'));
    }

    public function testInvalids(): void
    {
        $this->assertFalse($this->rule->check('USERNAME'));
        $this->assertFalse($this->rule->check('Username'));
        $this->assertFalse($this->rule->check('userName'));
    }
}
