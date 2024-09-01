<?php

// src/Controller/FeedBackController.php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FeedBackController extends AbstractController
{
    #[Route('/api/feedback', name: 'feedback', methods: ['POST'])]
    public function sendContactEmail(MailerInterface $mailer, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user_id = $data['user_id'];
        $user_email = $data['user_email'];
        $type = $data['type'];
        $message = $data['message'];


        // Générer le contenu HTML pour l'email destiné à l'utilisateur
        $htmlContentUser = $this->renderView('email/feedback_email.html.twig', []);

        // Générer le contenu HTML pour l'email destiné à vous (administrateur)
        $htmlContentMe = $this->renderView('email/feedback_testeur_me.html.twig', [
            'user_id' => $user_id,
            'user_email' => $user_email,
            'type' => $type,
            'message' => $message,
        ]);

        // Créer l'email pour l'utilisateur
        $userEmail = (new Email())
            ->from('no-reply@maker-copilot.com')
            ->to($user_email) // Envoi à l'utilisateur
            ->subject('Confirmation de réception de votre demande sur Maker Copilot')
            ->html($htmlContentUser); // Utiliser le contenu HTML du template

        // Créer l'email pour l'administrateur
        $adminEmail = (new Email())
            ->from('no-reply@maker-copilot.com')
            ->to('m.fleury942@gmail.com') // Envoi à l'administrateur principal
            ->addTo('contact@maker-copilot.com') // Ajout d'un autre destinataire
            ->subject('Message formulaire de contact home page Maker Copilot')
            ->html($htmlContentMe); // Utiliser le contenu HTML du template


        // Envoyer les emails
        try {
            // Envoyer l'email à l'utilisateur
            $mailer->send($userEmail);

            // Envoyer l'email à l'administrateur
            $mailer->send($adminEmail);

            return new JsonResponse(['status' => 'success', 'message' => 'Les emails ont été envoyés avec succès.'], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
