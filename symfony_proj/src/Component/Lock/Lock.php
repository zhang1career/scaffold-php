<?php

namespace App\Component\Lock;

use Symfony\Component\Lock\LockInterface;

interface Lock
{
    public function lock($resourceId) : ?LockInterface;

    public function unlock(LockInterface $lock);
}