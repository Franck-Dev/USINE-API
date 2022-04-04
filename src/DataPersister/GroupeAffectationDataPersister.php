<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\GroupeAffectation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class GroupeAffectationDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->_entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    
    public function supports($data, array $context = []): bool
    {
        return $data instanceof GroupeAffectation;
    }

    public function persist($data, array $context = [])
    {
        $data->setCreatedAt(new \DateTimeImmutable());
        
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}