<?php

namespace Rakit\Validation\Tests;

use Rakit\Validation\Rules\Uppercase;
use PHPUnit\Framework\TestCase;

class UppercaseTest extends TestCase
{

    public $rule;
    protected function setUp():void
    {
        $this->rule = new Uppercase;
    }

    public function testValids(): void
    {
        $this->assertTrue($this->rule->check('USERNAME'));
        $this->assertTrue($this->rule->check('FULL NAME'));
        $this->assertTrue($this->rule->check('FULL_NAME'));
    }

    public function testInvalids(): void
    {
        $this->assertFalse($this->rule->check('username'));
        $this->assertFalse($this->rule->check('Username'));
        $this->assertFalse($this->rule->check('userName'));
    }
}
