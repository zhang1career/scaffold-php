<?php

namespace App\Service\Impl;

use App\Api\UserApi;
use App\Component\Lock\Lock;
use App\Model\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use DateTime;
use Doctrine\DBAL\Exception;
use RuntimeException;
use Symfony\Component\Lock\LockInterface;

class UserServiceImpl implements UserService
{
    private UserRepository $userRepo;
    private UserApi $userApi;
    private Lock $lock;

    public function __construct(UserRepository $userRepo, UserApi $userApi, Lock $lock) {
        if ($userRepo === null) {
            throw new RuntimeException("UserRepository should not be null.");
        }
        $this->userRepo = $userRepo;
        $this->userApi = $userApi;
        $this->lock = $lock;
    }

    public function getCachedInfo(array $conditionList, int $liveTime, string $timeUnit) {
        $userId = $conditionList['id'];
        // query db
        list($startTime, $stopTime) = $this->buildTimeRange($liveTime, $timeUnit);
        $cachedUser = $this->userRepo->findOneById($userId);
        if ($cachedUser && $cachedUser->getUpdatedTm() >= $startTime) {
            return $cachedUser;
        }

        $resourceId = getmypid();
        $_lock = $this->lock($resourceId);
        if (!$_lock) {
            return null;
        }

        $savedUserId = null;
        $retry = 3;
        while ($retry--) {
            try {
                $savedUserId = $this->updateCache($conditionList, $cachedUser);
                break;
            } catch (Exception $e) {
                unset($e);
            }
        }
        $this->unlock($_lock);

        // return cached data
        return $savedUserId ? $cachedUser : null;
    }

    private function updateCache(array $conditionList, $cachedUser) : int {
        $userId = $conditionList['id'];
        // query api
        $apiUser = $this->userApi->findOneBy($userId);
        if (!$apiUser) {
            throw new Exception();
        }

        // cache data
        if ($cachedUser === null) {
            $cachedUser = new User();
        }
        $cachedUser->setName($apiUser->getName());
        $cachedUser->setUpdatedTm(new DateTime());
        $savedUserId = $this->userRepo->save($cachedUser);
        return $savedUserId;
    }

    private function lock($resourceId) : ?LockInterface {
        $resourceId = 'app:' . 'l:' . $resourceId;

        $_lock = null;
        $retry = 3;
        while ($retry--) {
            $_lock = $this->lock->lock($resourceId);
            if ($_lock) {
                break;
            }
            sleep(1);
        }

        return $_lock;
    }

    private function unlock($_lock) {
        $this->lock->unlock($_lock);
    }

    /**
     * @param int $liveTime
     * @param string $timeUnit
     * @return array
     */
    private function buildTimeRange(int $liveTime, string $timeUnit) : array {
        $liveStr = '-' . $liveTime . ' ' . $timeUnit;
        $stopTime = new Datetime();
        $startTime = $stopTime->modify($liveStr);
        return array($startTime, $stopTime);
    }
}