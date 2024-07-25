<?php
// src/Entity/ViewCanalMonthProduct.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: "view_canal_month_product")]
#[ApiResource(
    paginationMaximumItemsPerPage: 1000, // Permet jusqu'à 100 résultats par page
    paginationClientItemsPerPage: true,
    paginationEnabled: false,
    operations: [
        new GetCollection(),
        new Get(),
    ]
)] 
#[ApiFilter(SearchFilter::class, properties: ['product_id' => 'exact', 'month' => 'exact', 'years' => 'exact'])]
#[ApiFilter(RangeFilter::class, properties: ['month', 'years'])]
#[ApiFilter(OrderFilter::class, properties: ['price_value' => 'DESC'])]

class ViewCanalMonthProduct
{
    #[ORM\Column(type: "integer")]
    public int $user_id;

    #[ORM\Column(type: "integer")]
    public int $product_id;

    #[ORM\Column(type: "integer")]
    #[ORM\Id]
    public int $canal_id;

    #[ORM\Column(type: "string", length: 255)]
    public string $name;

    #[ORM\Column(type: "float")]
    public float $benefit_value;

    #[ORM\Column(type: "float")]
    public float $price_value;

    #[ORM\Column(type: "integer")]
    public int $nb_product_value;

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
