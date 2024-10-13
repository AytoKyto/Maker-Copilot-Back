<?php
// src/Controller/TestEmailController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Ayto\NewslaterBundle\Service\Mail\EmailService;
use Ayto\NewslaterBundle\Service\Mail\EmailTemplates;

class TestEmailController extends AbstractController
{
    private EmailService $emailService;

    public function __construct(
        EmailService $emailService,
    ) {
        $this->emailService = $emailService;
    }
    #[Route('/api/test-email', name: 'test_email', methods: ['GET'])]
    public function sendTestEmail(MailerInterface $mailer, Request $request): JsonResponse
    {
        // Adresse email de test, peut être passée en paramètre de requête
        $testEmail = $request->query->get('email', 'test@example.com');

        try {
        // Créer un email de test
       $this->emailService->sendEmail('no-reply@maker-copilot.com', $testEmail, 'Ceci est un email de test envoyé depuis Symfony.', EmailTemplates::TEST_EMAIL, []);
            return new JsonResponse(['status' => 'success', 'message' => 'Email envoyé avec succès à ' . $testEmail], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
