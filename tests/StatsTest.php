<?php

/**
 * StatsTest.php
 *
 * @author David Yell <dyell@ukwebmedia.com>
 * @copyright 2017 UK Web Media Ltd
 */

namespace tests;

use neon1024\FF8Corral\Lib\Stats;
use PHPUnit\Framework\TestCase;

class StatsTest extends TestCase
{
    public function testGetJunctions()
    {
        $result = Stats::list();
        $expected = [
            'HP-J',
            'Str-J',
            'Vit-J',
            'Mag-J',
            'Spr-J',
            'Spd-J',
            'Eva-J',
            'Hit-J',
            'Luck-J',
        ];

        $this->assertEquals($expected, $result);
    }

    public function testGetJunctionPriorities()
    {
        $result = Stats::list();

        $this->assertNotEmpty($result);
        $this->assertInternalType('array', $result);
    }
}