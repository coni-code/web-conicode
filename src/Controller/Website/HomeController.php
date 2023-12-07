<?php

namespace App\Controller\Website;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('', name: 'app_home')]
    public function index(): Response
    {
        $form = $this -> createForm(ContactType::class);
        return $this->render('website/home.html.twig',[
            'contact_form' => $form,
        ]);
    }
}

