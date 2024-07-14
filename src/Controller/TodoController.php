<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route("/todo")]
class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();

        if (!$session->has('todos')) {
            $todos = [
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash(
               'info',
               "La liste des todos viens d'être initialisé"
            );
        }
        return $this->render('todo/index.html.twig');
    }

    #[Route(
        '/add/{name?default}/{content?default}', 
        name: 'app_todo_add',
        //soit on met des valeur par default ici soit a coté des truc de la route tjr remplir les valeurde droite a gauche
        // defaults: ['name' => 'techwall', 'content' => 'sf6']
        )]
    public function addTodo(Request $request, $name, $content): Response
    {
        $session = $request->getSession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                $this->addFlash(
                    'error',
                    "Le todo d'id $name existe déjà dans la liste"
                );
            }else {
                $todos[$name] = $content;
                $this->addFlash(
                    'success',
                    "Le todo d'id $name à été ajouté avec succès"
                );
                $session->set('todos', $todos);
            }
        }else {
            $this->addFlash(
                'error',
                "La liste des todos n'est pas encore initialisé"
             );
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/update/{name}/{content}', name: 'app_todo_update')]
    public function updateTodo(Request $request, $name, $content): Response
    {
        $session = $request->getSession();

        if ($session->has('todos')) {

            $todos = $session->get('todos');

            if (isset($todos[$name])) {
                $todos[$name] = $content;
                $session->set('todos', $todos);

                $this->addFlash(
                    'success',
                    "Le todo d'id $name à été mis à jour avec succès"
                );
            }else {
                $this->addFlash(
                    'error',
                    "Le todo d'id $name n'existe pas"
                );
            }
        }else {
            $this->addFlash(
                'error',
                "La liste des todos n'est pas encore initialisé"
             );
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/delete/{name}', name: 'app_todo_delete')]
    public function deleteTodo(Request $request, $name): Response
    {
        $session = $request->getSession();

        if ($session->has('todos')) {

            $todos = $session->get('todos');

            if (isset($todos[$name])) {
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash(
                    'success',
                    "Le todo d'id $name à été supprimé avec succès"
                );
            }else {
                $this->addFlash(
                    'error',
                    "Le todo d'id $name n'existe pas"
                );
            }
        }else {
            $this->addFlash(
                'error',
                "La liste des todos n'est pas encore initialisé"
             );
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/reset', name: 'app_todo_reset')]
    public function resetTodo(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('app_todo'); 
    }



}
