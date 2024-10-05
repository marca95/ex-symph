<?php

namespace App\Controller;

use App\Entity\Personne;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonneController extends AbstractController
{
    #[Route('/personne/add', name: 'personne.add')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $personne = new Personne();
        $personne->setFirstname('Pierre');
        $personne->setName('Majerus');
        $personne->setAge('29');

        $personne2 = new Personne();
        $personne2->setFirstname('Annelise');
        $personne2->setName('Gillet');
        $personne2->setAge('28');

        $entityManager->persist($personne);
        $entityManager->persist($personne2);
        // Executer la transaction
        $entityManager->flush();

        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    }
}
