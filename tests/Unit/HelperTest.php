<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
   function testHelpersStatusCodeAssertIsString()
    {
        $this->assertIsString(statusCode(200));
    }

    function testHelpersStatusCodeAssertEquals()
    {
        $this->assertEquals('OK', statusCode(200));
    }

//    function testHelperArrayToObject(){
//       $this->assertObjectEquals((\stdClass::class)['message' => 'Test'], arrayToObject('Test', 200));
//    }
}
