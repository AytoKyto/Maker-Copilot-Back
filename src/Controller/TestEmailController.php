<?php
// src/Controller/TestEmailController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class TestEmailController extends AbstractController
{
    #[Route('/api/test-email', name: 'test_email', methods: ['GET'])]
    public function sendTestEmail(MailerInterface $mailer, Request $request): JsonResponse
    {
        // Adresse email de test, peut être passée en paramètre de requête
        $testEmail = $request->query->get('email', 'test@example.com');

        // Rendre le contenu HTML à partir du template Twig
        $htmlContent = $this->renderView('email/test_email.html.twig', [
            // Vous pouvez passer des variables au template ici si nécessaire
        ]);

        // Créer un email de test
        $email = (new Email())
            ->from('no-reply@maker-copilot.com')
            ->to($testEmail) // Utilisation de l'email passé en paramètre
            ->subject('Email de Test')
            ->text('Ceci est un email de test envoyé depuis Symfony.')
            ->html($htmlContent); // Utiliser le contenu HTML du template

        // Envoyer l'email
        try {
            $mailer->send($email);
            return new JsonResponse(['status' => 'success', 'message' => 'Email envoyé avec succès à ' . $testEmail], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
