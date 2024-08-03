<?php
// src/Entity/ViewBestProductSalesYearCanal.php

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
#[ORM\Table(name: "view_best_product_sales_year_canal")]
#[ApiResource(
    paginationMaximumItemsPerPage: 1000, // Permet jusqu'à 100 résultats par page
    paginationClientItemsPerPage: true,
    paginationEnabled: false,
    operations: [
        new GetCollection(),
        new Get(),
    ]
)] 
#[ApiFilter(SearchFilter::class, properties: ['canal_id' => 'exact','product_id' => 'exact', 'years' => 'exact', 'user_id' => 'exact'])]
#[ApiFilter(RangeFilter::class, properties: ['month', 'years'])]
#[ApiFilter(OrderFilter::class, properties: ['classement' => 'DESC', 'price_value' => 'DESC'])]

class ViewBestProductSalesYearCanal
{
    #[ORM\Column(type: "integer")]
    public int $user_id;

    #[ORM\Column(type: "integer")]
    #[ORM\Id]
    public int $classement;

    #[ORM\Column(type: "integer")]
    public int $product_id;

    #[ORM\Column(type: "integer")]
    public int $canal_id;

    #[ORM\Column(type: "string")]
    public string $product_name;

    #[ORM\Column(type: "integer")]
    public int $nb_product;

    #[ORM\Column(type: "string", length: 4)]
    public string $years;
}
