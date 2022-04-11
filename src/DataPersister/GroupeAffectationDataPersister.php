<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\GroupeAffectation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class GroupeAffectationDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

/**
     *
     * @var Security
     */
    private $_security;

    public function __construct(
        EntityManagerInterface $entityManager, Security $security
    )
    {
        $this->_entityManager = $entityManager;
        $this->_security = $security;
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
        if (!$data->getCreatedAt()) {
            
            $data->setCreatedAt(new \DateTimeImmutable());
            $data->setProprietaire($this->_security->getUser()->getService());

        } else {
            $data->setDateDernierAjout(new \DateTimeImmutable());
        }

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}