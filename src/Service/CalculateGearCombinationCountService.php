<?php

namespace App\Service;

class CalculateGearCombinationCountService
{
    /**
     * @param int $frontCogCount
     * @param int $rearCogCount
     * @return int
     */
    public function calculate(int $frontCogCount, int $rearCogCount): int
    {
        return $frontCogCount * $rearCogCount;
    }
}