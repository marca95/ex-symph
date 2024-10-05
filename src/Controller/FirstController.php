<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FirstController extends AbstractController
{
    #[Route('/order/{maVar}', name: 'test.order.route')]
    public function testOrderRoute($maVar)
    {
        return new Response("<html><body>$maVar</body></html>");
    }

    #[Route('/first', name: 'first')]
    public function index(): Response
    {
        // Nous pouvons aller chercher à la base de données les users
        // pour les templates
        return $this->render('first/index.html.twig', [
            'name' => 'Majerus',
            'firstname' => 'Pierre'
        ]);
    }

    #[Route('/sayHello/{name}/{firstname}', name: 'say.hello')]
    public function sayHello(Request $request, $name, $firstname): Response
    {
        return $this->render('first/hello.html.twig', [
            'nom' => $name,
            'prenom' => $firstname,
            'path' => 'Pierre.png'
        ]);
    }

    #[Route('multi/{entier1}/{entier2}', name: 'multiplication', requirements: ['entier1' => '\d+', 'entier2' => '\d+'])]
    // Le requirement sert de contrainte, ce qu'il peut etre
    public function multiplication($entier1, $entier2)
    {
        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");
    }
}
