<?php

namespace App\Service;

use App\Exception\AgeException;

/**
 * Class AgeService
 * @author Yann Le Scouarnec <bunkermaster@gmail.com>
 * @package App\Service
 */
class AgeService
{
    public function get(\DateTimeInterface $dob): int
    {
        $now = new \DateTime();
        if($now < $dob){
            throw new AgeException('woooot');
        }
        return $now->diff($dob)->y;
    }
}