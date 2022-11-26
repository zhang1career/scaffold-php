<?php

namespace App\Component\Lock\Impl;

use App\Component\Lock\Lock;
use Predis\Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\LockInterface;
use Symfony\Component\Lock\Store\RedisStore;

class RedisLockImpl implements Lock
{
    private $factory;

    public function __construct(ParameterBagInterface $params) {
        $store = new RedisStore(new Client('tcp://' . $params->get('REDIS_HOST') . ':' . $params->get('REDIS_PORT')));
        $this->factory = new LockFactory($store);
    }

    public function lock($resourceId) : ?LockInterface {
        $lock = $this->factory->createLock($resourceId);
        if (!$lock->acquire()) {
            return null;
        }
        return $lock;
    }

    public function unlock(LockInterface $lock) {
        $lock->release();
    }
}