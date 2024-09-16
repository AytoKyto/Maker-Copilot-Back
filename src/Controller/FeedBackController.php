<?php

// src/Controller/FeedBackController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Request\FeedbackRequest;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\Mail\EmailService;

class FeedBackController extends AbstractController
{

    private EmailService $emailService;

    public function __construct(
        EmailService $emailService,
    ) {
        $this->emailService = $emailService;
    }

    #[Route('/api/feedback', name: 'feedback', methods: ['POST'])]
    public function sendContactEmail(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Créez l'objet FeedbackRequest avec les données reçues
        $feedbackRequest = new FeedbackRequest(
            $data['user_id'] ?? null,
            $data['user_email'] ?? '',
            $data['type'] ?? '',
            $data['message'] ?? ''
        );

        // Validez les données de l'objet FeedbackRequest
        $errors = $validator->validate($feedbackRequest);

        // Vérifiez si des erreurs de validation sont présentes
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return new JsonResponse(['status' => 'error', 'errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Récupérez les valeurs depuis le FeedbackRequest
        $user_id = $feedbackRequest->getUserId();
        $user_email = $feedbackRequest->getUserEmail();
        $type = $feedbackRequest->getType();
        $message = $feedbackRequest->getMessage();

        // Générer le contenu HTML pour l'email destiné à l'utilisateur
        $htmlContentUser = $this->renderView('email/feedback_email.html.twig');

        // Générer le contenu HTML pour l'email destiné à vous (administrateur)
        $htmlContentMe = $this->renderView('email/feedback_testeur_me.html.twig');

        try {
            $this->emailService->sendEmail($user_email, 'Confirmation de réception de votre demande sur Maker Copilot', $htmlContentUser, []);
            $this->emailService->sendEmail($user_email, 'Message formulaire de contact home page Maker Copilot', $htmlContentMe, [
                'user_id' => $user_id,
                'user_email' => $user_email,
                'type' => $type,
                'message' => $message,
            ]);
            return new JsonResponse(['status' => 'success', 'message' => 'Les emails ont été envoyés avec succès.'], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
