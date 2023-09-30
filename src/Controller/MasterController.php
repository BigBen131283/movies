<?php

namespace App\Controller;

use App\Entity\Master;
use App\Entity\Slave;
use App\Form\MasterType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/master')]
class MasterController extends AbstractController
{
    #[Route('/', name: 'app_master')]
    public function index(): Response
    {
        return $this->render('master/index.html.twig', [
            'controller_name' => 'MasterController',
        ]);
    }

    #[Route('/addTool', name: 'addTool')]
    public function addTool(
        // int $idMaster,
        // int $idSlave,
        EntityManagerInterface $em,
        Request $request
    )
    {
        $masterRepo = $em->getRepository(Master::class);
        $slaveRepo = $em->getRepository(Slave::class);
        $slave = $slaveRepo->findAll();
        
        $master = new Master();
        
        $form = $this->createForm(MasterType::class, $master);
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            $master = $masterRepo->findOneBy(['name'=>$master->getName()]);
            // dump($master);
            $master->setName('Zorro');
            $em->persist($master);
            $em->flush();
        }

        return $this->render('master/index.html.twig', [
            'formMaster' => $form
        ]);
    }

    public function setMasterParam(
        $name,
        EntityManager $em
    )
    {
        $masterRepo = $em->getRepository(Master::class);
    }
}


