<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class FirstController extends AbstractController
{

    #[Route('/order/{maVar}', name: "app_test_order_route",)]
    public function testOrderRoute($maVar){
        return new Response("<html><body>$maVar</body></html>");
    }


    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'name' => 'Milhau',
            'firstname' => 'Julien'
        ]);
    }


    #[Route('/hello/{name}/{firstname}', name: 'app_hello')]
    public function sayHello(Request $request, $name, $firstname): Response
    {
        return $this->render('first/hello.html.twig',[
            'name' => $name, 
            'firstname' => $firstname
        ]);
    }

    //pour gere les expression reguliere  => https://regexr.com/
    #[Route(
        //forme simplifie de requirements
        '/multi/{entier1<\d+>}/{entier<\d+>}',
        name: "app_multiplication",
        // requirements: ['entier1' => '\d+', 'entier2' => '\d+']
    )]
    public function multiplication($entier1, $entier2){
        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");
    }
    

}
