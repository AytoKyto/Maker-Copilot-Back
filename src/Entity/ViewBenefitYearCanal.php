<?php

// src/Entity/ViewBenefitYearCanal.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: "view_benefit_year_canal")]
#[ApiResource(
    paginationMaximumItemsPerPage: 1000, // Permet jusqu'à 100 résultats par page
    paginationClientItemsPerPage: true,
    paginationEnabled: false,
    operations: [
        new GetCollection(),
    ]
)] 
#[ApiFilter(OrderFilter::class, properties: ['date_full' => 'DESC'])]
#[ApiFilter(SearchFilter::class, properties: ['canal_id' => 'exact', 'years' => 'exact', 'user_id' => 'exact'])]


class ViewBenefitYearCanal
{
    #[ORM\Column(type: "integer")]
    public int $user_id;

    #[ORM\Column(type: "integer")]
    public int $canal_id;

    #[ORM\Column(type: "integer")]
    public int $nb_product;

    #[ORM\Column(type: "float")]
    public float $benefit_value;

    #[ORM\Column(type: "float")]
    public float $price_value;

    #[ORM\Column(type: "float")]
    public float $benefit_pourcent;

    #[ORM\Id]
    #[ORM\Column(type: "string", length: 4)]
    public string $years;
}
