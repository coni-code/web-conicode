<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class FileController extends AbstractController
{
    #[Route('/admin/download-cv/{id}', name: 'dev_download_cv')]
    public function downloadCv(User $user): BinaryFileResponse
    {
        $filePath = $this->getParameter('kernel.project_dir') . '/var/uploads/cv/' . $user->getCvFilename();

        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('The file does not exist');
        }

        $extension = pathinfo($user->getCvFilename(), PATHINFO_EXTENSION);
        $filename = sprintf(
            '%s-%s-%s.%s',
            $user->getName(),
            $user->getSurname(),
            (new \DateTime('now'))->format('Y'),
            $extension,
        );
        $response = new BinaryFileResponse($filePath);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);

        return $response;
    }
}
