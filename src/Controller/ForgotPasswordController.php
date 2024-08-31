<?php

// src/Controller/ForgotPasswordController.php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ForgotPasswordController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/api/forgot-password', name: 'forgot-password', methods: ['POST'])]
    public function resetPassword(Request $request, MailerInterface $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;

        // Vérifier que l'email est fourni
        if (!$email) {
            return new JsonResponse(['status' => 'error', 'message' => 'Email requis'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Rechercher l'utilisateur par email
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        // Vérifier si l'utilisateur existe
        if (!$user) {
            return new JsonResponse(['status' => 'error', 'message' => 'Utilisateur non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Générer un nouveau mot de passe aléatoire
        $newPassword = bin2hex(random_bytes(5)); // Génère un mot de passe de 10 caractères

        // Hash du nouveau mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($user, $newPassword);

        // Mettre à jour l'utilisateur avec le nouveau mot de passe
        $user->setPassword($hashedPassword);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Rendre le contenu HTML à partir du template Twig
        $htmlContent = $this->renderView('email/password_email.html.twig', [
            'newpassword' => $newPassword, // Passer le nouveau mot de passe au template
        ]);


        // Envoyer un email avec le nouveau mot de passe
        $emailMessage = (new Email())
            ->from('no-reply@maker-copilot.com')
            ->to($user->getEmail())
            ->subject('Votre nouveau mot de passe')
            ->html($htmlContent); // Utiliser le contenu HTML du template

        try {
            $mailer->send($emailMessage);
            return new JsonResponse(['status' => 'success', 'message' => 'Un nouveau mot de passe a été envoyé à ' . $user->getEmail()], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
