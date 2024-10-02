<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

// Pour éviter de mettre todo a toutes les routes
#[Route("/todo")]
class ToDoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->has('todos')) {
            $todos = [
                'achat' => 'acheter des clés usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mes examens',
            ];
            $session->set('todos', $todos);
            // Les flash back session ne dure que lors du téléchargement de la page
            // Une fois un refresh il disparait
            $this->addFlash('info', 'La liste des todos vient d\'être initialisée');
        }
        return $this->render('to_do/index.html.twig',);
    }

    #[Route('/add/{name}/{content}', name: 'todo.add', defaults: ['content' => 'Pas de donnée rentrée.'])]
    public function addTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                $this->addFlash('erreur', 'Le todo existe déjà');
            } else {
                $todos[$name] = $content;
                $this->addFlash('succès', 'Le todo est bien enregistrée');
                $session->set('todos', $todos);
            }
        } else {
            $this->addFlash('erreur', 'La liste des todos n\'est pas encore initialisée');
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/update/{name}/{content?Pas de donnée rentrée}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                $this->addFlash('erreur', 'Le todo n\'existe pas.');
            } else {
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('succès', 'Le todo a bien été modifié');
            }
        } else {
            $this->addFlash('erreur', 'La liste des todos n\'est pas encore initialisée');
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/delete/{name}/', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse
    {
        $session = $request->getSession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                $this->addFlash('erreur', 'Le todo n\'existe pas.');
            } else {
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('succès', 'Le todo a bien été supprimé');
            }
        } else {
            $this->addFlash('erreur', 'La liste des todos n\'est pas encore initialisée');
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/reset/', name: 'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $session->remove('todos');

        return $this->redirectToRoute('todo');
    }
}
