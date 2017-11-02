<?php

use PHPUnit\Framework\TestCase;

/**
 * A Test Sceleton
 */
class Test extends TestCase
{
    public function testReady()
    {
        $this->assertTrue(version_compare(PHP_VERSION, "7.0.0", "ge")) ;
    }
}
