<?php

namespace App\Service;

interface UserService
{
    /**
     * @param array $conditionList
     * @param int $liveTime
     * @param string $timeUnit
     * @return mixed
     */
    public function getCachedInfo(array $conditionList, int $liveTime, string $timeUnit);
}