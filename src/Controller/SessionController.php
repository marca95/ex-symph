<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'session')]
    public function index(Request $request): Response
    {
        // En php, ceci est égal à session_start()
        $session = $request->getSession();
        if ($session->has('nbrVisit')) {
            $nbrVisit = $session->get('nbrVisit') + 1;
        } else {
            $nbrVisit = 1;
        }
        $session->set('nbrVisit', $nbrVisit);
        return $this->render('session/index.html.twig');
    }
}
