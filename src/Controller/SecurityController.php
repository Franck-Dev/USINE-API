<?php
// api/src/Controller/SecurityController.php

namespace App\Controller;

use DateTimeImmutable;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
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
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    
    public function login()
    {
        if (!$this->getUser()){
            return $this->json([
                'message' => 'Mauvais mot de passe ou login']);  
        }else{
            //Récupération de la dernière date de connexion
            $lastConnexion=$this->getUser()->getLastCon();
            //Enregistrement de la date de connexion
            $this->getUser()->setLastCon(new \DateTimeImmutable);
            $this->_entityManager->persist($this->getUser());
            $this->_entityManager->flush();
            
            return $this->json([
                'user' => $this->getUser(),
                'lastCon' => $lastConnexion,
                'apiToken' => $this->getUser()->getApiToken()]);
        } 
    }

    /**
     * @Route("/api/logout", name="api_logout", methods={"GET"})
     */
    public function logout()
    {
        throw new \Exception('should not be reached');
    }
}
