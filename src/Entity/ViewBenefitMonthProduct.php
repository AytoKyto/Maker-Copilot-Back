<?php

// src/Entity/ViewBenefitMonthProduct.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: "view_benefit_month_product")]
#[ApiResource(
    paginationEnabled: false,
    operations: [
        new GetCollection(),
    ]
)]
#[ApiFilter(RangeFilter::class, properties: ['month', 'years'])]
#[ApiFilter(OrderFilter::class, properties: ['date_full' => 'DESC'])]


class ViewBenefitMonthProduct
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    public int $user_id;

    #[ORM\Column(type: "integer")]
    public int $product_id;

    #[ORM\Column(type: "float")]
    public float $benefit_value;

    #[ORM\Column(type: "float")]
    public float $price_value;

    #[ORM\Column(type: "float")]
    public float $ursaf_value;

    #[ORM\Column(type: "float")]
    public float $expense_value;

    #[ORM\Column(type: "float")]
    public float $commission_value;

    #[ORM\Column(type: "float")]
    public float $time_value;

    #[ORM\Column(type: "float")]
    public float $benefit_pourcent;

    #[ORM\Column(type: "string", length: 4)]
    public string $years;

    #[ORM\Column(type: "string", length: 2)]
    public string $month;

    #[ORM\Column(type: "string", length: 7)]
    public string $date_full;
}
