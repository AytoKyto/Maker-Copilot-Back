<?php

// src/Entity/ViewBenefitYearCategory.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: "view_benefit_month_category")]
#[ApiResource(
    paginationMaximumItemsPerPage: 1000, // Permet jusqu'à 100 résultats par page
    paginationClientItemsPerPage: true,
    paginationEnabled: false,
    operations: [
        new GetCollection(),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['category_id' => 'exact', 'years' => 'exact', 'user_id' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['years' => 'DESC'])]


class ViewBenefitYearCategory
{
    #[ORM\Column(type: "integer")]
    public int $user_id;

    #[ORM\Column(type: "string")]
    #[ORM\Id]
    public string $name;

    #[ORM\Column(type: "integer")]
    public int $nb_product;

    #[ORM\Column(type: "integer")]
    public int $category_id;

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
}