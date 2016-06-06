<?php

namespace BlackfyreStudio\CRUD\Tests;

class BasicTest extends \PHPUnit_Framework_TestCase
{
    public function testSomethingIsTrue()
    {
        $this->visit('/');

        $this->assertTrue(true);
    }
}
