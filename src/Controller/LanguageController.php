<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/change-language', name: 'app_language_')]
class LanguageController extends AbstractController
{
    #[Route('/', name: 'changer', methods: ['GET'])]
    public function changeLanguage(Request $request): Response
    {
        $locale = $request->getLocale();

        return match ($locale) {
            'pl', 'en' => $this->redirectToRoute('app_home'),
            default    => $this->redirect($request->headers->get('referer')),
        };
    }
    #[Route('/admin', name: 'admin_changer', methods: ['GET'])]
    public function changeAdminLanguage(Request $request): Response
    {
        $locale = $request->getLocale();

        return match ($locale) {
            'pl', 'en' => $this->redirectToRoute('dev_admin'),
            default    => $this->redirect($request->headers->get('referer')),
        };
    }
}
