<?php
// src/Controller/RegistrationController.php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegistrationController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;
    private $jwtManager;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, JWTTokenManagerInterface $jwtManager)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->jwtManager = $jwtManager;
    }

    #[Route('/register', name: 'register', methods: 'POST')]
    public function register(Request $request, MailerInterface $mailer): JsonResponse
    {
        $time = new \DateTimeImmutable();

        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        $user->setCreatedAt($time);
        $user->setUpdatedAt($time);
        $user->setTypeSubscription(0);
        $user->setAbatementPourcent(0);
        $user->setRoles(['ROLE_USER']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $jwt = $this->jwtManager->create($user);

        $htmlContent = $this->renderView('email/test_email.html.twig', []);

        // Envoi de l'email de confirmation
        $email = (new Email())
            ->from('no-reply@maker-copilot.com')
            ->to($user->getEmail())
            ->subject('Bienvenue sur Maker Copilot!')
            ->html($htmlContent); // Utiliser le contenu HTML du template

        $mailer->send($email);

        return new JsonResponse(['token' => $jwt], Response::HTTP_CREATED);
    }
}
