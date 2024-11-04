<?php
namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\RapportDataController;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/rapport/data',
            controller: RapportDataController::class,
            openapiContext: [
                'parameters' => [
                    [
                        'name' => 'date1',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'string', 'format' => 'date'],
                        'description' => 'La première date de la première plage (YYYY-MM-DD)'
                    ],
                    [
                        'name' => 'date2',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'string', 'format' => 'date'],
                        'description' => 'La deuxième date de la première plage (YYYY-MM-DD)'
                    ],
                    [
                        'name' => 'date3',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'string', 'format' => 'date'],
                        'description' => 'La première date de la deuxième plage (YYYY-MM-DD)'
                    ],
                    [
                        'name' => 'date4',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'string', 'format' => 'date'],
                        'description' => 'La deuxième date de la deuxième plage (YYYY-MM-DD)'
                    ]
                ],
                'summary' => 'Récupérer des utilisateurs entre deux plages de dates',
                'description' => 'Cette opération retourne des utilisateurs dont la date de création se trouve entre les deux plages de dates spécifiées.'
            ],
            read: false,
            name: 'get_rapport_data',
        ),
    ]
)]
class RapportData
{
}
