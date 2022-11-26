<?php

namespace App\Component;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

class DbDriver
{
    private EntityManager $entityManager;

    private Connection $conn;

    public function __construct(private ManagerRegistry $doctrine) {
        if ($this->doctrine === null) {
            throw new \RuntimeException("Doctrine should not be null.");
        }
        $this->entityManager = $this->doctrine->getManager();
        $this->conn = $this->entityManager->getConnection();
    }

    public function getConn() : Connection {
        return $this->conn;
    }
}