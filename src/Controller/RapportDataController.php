<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\SaleRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Security;

#[AsController]
class RapportDataController extends AbstractController
{
    private EntityManagerInterface $em;
    private SaleRepository $saleRepository;

    public function __construct(EntityManagerInterface $em, SaleRepository $saleRepository)
    {
        $this->em = $em;
        $this->saleRepository = $saleRepository;
    }

    /**
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function __invoke(Request  $request, SerializerInterface $serializer, JWTTokenManagerInterface $jwtManager,
                             Security $security): JsonResponse
    {
        $date1 = $request->query->get('date1');
        $date2 = $request->query->get('date2');

        $user = $security->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'User not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $userId = $user->getId();

        try {
            $startDate = new \DateTime($date1 . ' 00:00:00');
            $endDate = new \DateTime($date2 . ' 23:59:59');
        } catch (\Exception $e) {
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

        $sales = $this->saleRepository->findSalesProductBetweenDate($startDate, $endDate, $userId);
        $topProductSale = $this->saleRepository->getTopProductSaleBetweenDate($startDate, $endDate, $userId);
        $topCanalSale = $this->saleRepository->getTopCanalSaleBetweenDate($startDate, $endDate, $userId);
        $topClientSale = $this->saleRepository->getTopClientSaleBetweenDate($startDate, $endDate, $userId);

        $salesData = json_decode($serializer->serialize($sales, 'json', ['groups' => 'sale:read']), true);

        return new JsonResponse([
            'dataPriceDateOne' => $dataPriceDateOne,
            'topClientSale' => $topClientSale,
            'topCanalSale' => $topCanalSale,
            'topProductSale' => $topProductSale,
            'sales' => $salesData,
        ], 200);
    }


}
