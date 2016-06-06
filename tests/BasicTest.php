<?php

namespace BlackfyreStudio\CRUD\Tests;

use \Illuminate\Foundation\Testing\WithoutMiddleware;
use \Illuminate\Foundation\Testing\DatabaseMigrations;
use \Illuminate\Foundation\Testing\DatabaseTransactions;

class BasicTest extends \PHPUnit_Framework_TestCase
{
    public function testSomethingIsTrue()
    {
        $this->visit('/');
        
        $this->assertTrue(true);
    }
}
