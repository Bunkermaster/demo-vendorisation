<?php

namespace App\Tests;

use App\Service\AgeService;
use PHPUnit\Framework\TestCase;
use App\Exception\AgeException;

class AgeTest extends TestCase
{
    public function testSomething()
    {
        $age = new AgeService();
        $this->assertEquals(21, $age->get(new \DateTime('1996-08-30')));
    }

    /**
     * @expectedException App\Exception\AgeException
     */
    public function testException()
    {
        $age = new AgeService();
        $ageValue = $age->get(new \DateTime('2032-08-30'));
    }

    /**
     * @dataProvider ageProvider
     */
    public function testMultipleThings($expected, $a)
    {
        $age = new AgeService();
        $this->assertEquals($expected, $age->get($a));
    }

    public function ageProvider()
    {
        return [
            'adding zeros'  => [0, new \DateTime()],
            'zero plus one' => [10, new \DateTime('2008-04-30')],
        ];
    }
}
