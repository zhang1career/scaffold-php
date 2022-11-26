<?php

namespace App\Repository;

use App\Model\Entity\User;

interface UserRepository
{
    public function save(User $entity, bool $flush = false): int;

    public function remove(User $entity, bool $flush = false): void;

    public function findListById($id): array;

    public function findOneById($id): ?User;
}