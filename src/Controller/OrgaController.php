<?php
// api/src/Controller/OrgaController.php

namespace App\Controller;

use DateTimeImmutable;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\GroupeAffectation;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrgaController extends AbstractController
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

    public function __invoke(GroupeAffectation $data): GroupeAffectation
    {
        //$this->userPublishingHandler->handle($data);
        return $data;
    }
    

    
    /* public function affectUsers(User $data)
    {
        dump($data);
        if (!$this->getUser()){
            return $this->json([
                'message' => 'Il faut être connecté']);  
        }else{
            //Enregistrement de la date de connexion
            //$this->getUser()->setLastCon(new \DateTimeImmutable);
            $this->_entityManager->persist($this->getUser());
            $this->_entityManager->flush();
            
            return $this->json([
                'user' => $this->getUser()]);
        } 
    } */
}
