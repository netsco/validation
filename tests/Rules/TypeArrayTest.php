<?php

namespace Rakit\Validation\Tests;

use Rakit\Validation\Rules\TypeArray;
use PHPUnit\Framework\TestCase;

class TypeArrayTest extends TestCase
{

    public $rule;
    protected function setUp():void
    {
        $this->rule = new TypeArray;
    }

    public function testValids(): void
    {
        $this->assertTrue($this->rule->check([]));
        $this->assertTrue($this->rule->check([1,2,3]));
        $this->assertTrue($this->rule->check([1,2,[4,5,6]]));
    }

    public function testInvalids(): void
    {
        $this->assertFalse($this->rule->check('[]'));
        $this->assertFalse($this->rule->check('[1,2,3]'));
    }
}
