<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Mail\EmailService;
use App\Service\Validation\EmailUserExistValidation;
use App\Service\User\GeneratePersistPasswordService;

class ForgotPasswordController extends AbstractController
{
    private EmailService $emailService;
    private EmailUserExistValidation $emailUserExistValidation;
    private GeneratePersistPasswordService $generatePersistPasswordService;

    public function __construct(
        EmailService $emailService,
        EmailUserExistValidation $emailUserExistValidation,
        GeneratePersistPasswordService $generatePersistPasswordService
    ) {
        $this->emailService = $emailService;
        $this->emailUserExistValidation = $emailUserExistValidation;
        $this->generatePersistPasswordService = $generatePersistPasswordService;
    }

    #[Route('/api/forgot-password', name: 'forgot-password', methods: ['POST'])]
    public function resetPassword(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;

        try {
            // Validation de l'e-mail et récupération de l'utilisateur
            $user = $this->emailUserExistValidation->validateEmailUserExists($email);

            $newPassword = $this->generatePersistPasswordService->GenerateNewPassword($user);

            // Envoi de l'e-mail avec le nouveau mot de passe
            $htmlContent = 'email/password_email.html.twig';
            $contextEmail = ['newpassword' => $newPassword];
            $this->emailService->sendEmail($user->getEmail(), 'Votre nouveau mot de passe', $htmlContent, $contextEmail);

            return new JsonResponse(['status' => 'success', 'message' => 'Un nouveau mot de passe a été envoyé à ' . $user->getEmail()], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            // Gestion des autres erreurs (e.g., envoi de l'e-mail)
            return new JsonResponse(['status' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
