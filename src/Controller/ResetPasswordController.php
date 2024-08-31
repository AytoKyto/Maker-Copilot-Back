<?php

// src/Controller/ResetPasswordController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class ResetPasswordController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/api/reset-password', name: 'reset-password', methods: ['POST'])]
    public function ResetPassword(MailerInterface $mailer, Request $request): JsonResponse
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = $this->getUser();

        $data = json_decode($request->getContent(), true);
        $password = $data['password'];

        // Vérifier si l'utilisateur est bien authentifié
        if (!$user || !$user instanceof User) {
            return new JsonResponse(['status' => 'error', 'message' => 'Utilisateur non authentifié'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Hash du nouveau mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);

        // Mettre à jour l'utilisateur avec le nouveau mot de passe
        $user->setPassword($hashedPassword);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Rendre le contenu HTML à partir du template Twig
        $htmlContent = $this->renderView('email/info_password_email.html.twig', []);

        // Créer un email de réinitialisation de mot de passe
        $email = (new Email())
            ->from('no-reply@maker-copilot.com')
            ->to($user->getEmail()) // Utilisation de l'email de l'utilisateur
            ->subject('Réinitialisation de votre mot de passe')
            ->html($htmlContent); // Utiliser le contenu HTML du template

        // Envoyer l'email
        try {
            $mailer->send($email);
            return new JsonResponse(['status' => 'success', 'message' => 'Un nouveau mot de passe a été envoyé à ' . $user->getEmail()], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
