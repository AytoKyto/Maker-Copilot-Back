<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\SaleRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class RapportDataController extends AbstractController
{
    private EntityManagerInterface $em;
    private SaleRepository $saleRepository;
    private Client $client;

    public function __construct(
        EntityManagerInterface $em,
        SaleRepository         $saleRepository,
    )
    {
        $this->em = $em;
        $this->saleRepository = $saleRepository;
        $this->client = new Client();
    }

    private function getAnalysisReport(
        Request                  $request,
        SerializerInterface      $serializer,
        Security                 $security
    ): bool|string
    {
        $data = $request->toArray();

        $date1 = $data['date1'] ?? null;
        $date2 = $data['date2'] ?? null;


        $user = $security->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'User not authenticated'], Response::HTTP_UNAUTHORIZED);
        }

        $userId = $user->getId();

        try {
            $startDate = new \DateTime($date1 . ' 00:00:00');
            $endDate = new \DateTime($date2 . ' 23:59:59');
        } catch (Exception $e) {
            return new JsonResponse(['error' => 'Invalid date format. Please use YYYY-MM-DD.'], 400);
        }

        $dataPriceDateOne = $this->em->createQueryBuilder()
            ->from('App\Entity\Sale', 's')
            ->select('
                SUM(s.price) AS sumPrice, 
                SUM(s.benefit) AS sumBenefit,
                SUM(s.commission) AS sumCommission,
                SUM(s.time) AS sumTime
            ')
            ->andWhere('s.createdAt >= :startDate')
            ->andWhere('s.createdAt <= :endDate')
            ->andWhere('s.user = :userId')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('userId', $userId)
            ->orderBy('s.createdAt', 'ASC')
            ->getQuery()
            ->getResult();

      //  $sales = $this->saleRepository->findSalesProductBetweenDate($startDate, $endDate, $userId);
        $topProductSale = $this->saleRepository->getTopProductSaleBetweenDate($startDate, $endDate, $userId);
        $topCanalSale = $this->saleRepository->getTopCanalSaleBetweenDate($startDate, $endDate, $userId);
        $topClientSale = $this->saleRepository->getTopClientSaleBetweenDate($startDate, $endDate, $userId);

       // $salesData = json_decode($serializer->serialize($sales, 'json', ['groups' => 'sale:read']), true);

        return json_encode([
            'dataPriceDateOne' => $dataPriceDateOne,
            'topClientSale' => $topClientSale,
            'topCanalSale' => $topCanalSale,
            'topProductSale' => $topProductSale,
           // 'sales' => $salesData,
        ], true);

    }

    /**
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param Security $security
     * @return JsonResponse
     * @throws GuzzleException
     * @throws Exception
     */
    public function __invoke( Request                  $request,
                              SerializerInterface      $serializer,
                              Security                 $security): JsonResponse
    {
        try {
            $data = $request->toArray();

            $focus = $data['focus'] ?? null;
            $userMessage = $data['message'] ?? null;

            $prePromt = "Préprompt pour Maker Copilot : Maker Copilot, voici des données de vente et informations comptables pour analyse. L’utilisateur a spécifié un focus particulier et un message détaillé pour orienter l’analyse. Ton rôle est d’explorer les données en fonction des préférences de l’utilisateur et de fournir un rapport complet, avec des recommandations adaptées. Instructions de l’Utilisateur Focus : Le focus de l’analyse est {{focus}}. Concentre-toi principalement sur cet aspect lors de l’analyse. Message personnalisé : L’utilisateur a ajouté ce message pour clarifier sa demande : {{user_message}}. Merci de prendre en compte cette précision dans tes réponses. Types de Focus et Contenu attendu
Sales Analysis :
Analyse en profondeur des tendances de vente, incluant saisonnalité, produits les plus vendus, et clients actifs. Identifie les périodes de vente forte/faible et propose des stratégies d’optimisation.
Product Performance :
Étude de la rentabilité de chaque produit, avec des suggestions d’ajustement des prix, de réduction des coûts et d’optimisation des marges. Examine les catégories pour repérer celles avec le meilleur potentiel.
Customer Insights :
Analyse des segments clients, identification des clients les plus rentables, et recommandations pour la fidélisation et l'upselling. Compare les marges générées par client et leur fréquence d’achat.
Channel Analysis :
Évaluation des performances par canal de vente, avec une attention aux marges, aux commissions et aux coûts associés. Recommande des actions pour maximiser le potentiel des canaux performants.
Cost Optimization :
Analyse fine des coûts liés aux produits et aux canaux. Propose des moyens de réduire les coûts variables (commissions, URSSAF, frais généraux) pour chaque produit/canal.
Profitability Strategy :
Recommandations de stratégie pour augmenter les bénéfices, incluant des projections de scénarios pour ajuster les prix, commissions, et volumes de vente. Fournis des conseils de tarification et des ajustements pour optimiser la rentabilité globale.
Custom Analysis :
Effectue une analyse spécifique en fonction du message fourni par l’utilisateur. Adapte les recommandations aux besoins exprimés de manière flexible.
Merci de fournir un rapport structuré et détaillé avec des recommandations adaptées, en exploitant toutes les données JSON fournies. Donne moi uniquement le text que je doit données sois forme de HTML dans un <main>.";
            $message = [
                $prePromt,
                "userMessage" => [
                    'focus' => $focus,
                    'user_message' => $userMessage,
                    'data' => $this->getAnalysisReport($request, $serializer, $security)
                ]
            ];

            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_ENV["OPENAI_API_KEY"],
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    "model" => "gpt-4o",
                    "messages" => [
                        [
                            "role" => "system",
                            "content" => $prePromt
                        ],
                        [
                            "role" => "user",
                            "content" => json_encode($message)
                        ]
                    ],
                    "temperature" => 0.7
                ]
            ]);


            $body = $response->getBody()->getContents();
            return new JsonResponse(json_decode($body, true), Response::HTTP_OK);
        } catch (RequestException $e) {
            throw new Exception("Erreur lors de l'appel à l'API de l'assistant : " . $e->getMessage());
        }
    }
}
