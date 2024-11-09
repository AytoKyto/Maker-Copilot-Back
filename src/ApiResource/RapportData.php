<?php
namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\RapportDataController;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/rapport/data',
            controller: RapportDataController::class,
            openapiContext: [
                'requestBody' => [
                    'required' => true,
                    'content' => [
                        'application/ld+json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'date1' => [
                                        'type' => 'string',
                                        'format' => 'date',
                                        'description' => 'La première date de la première plage (YYYY-MM-DD)'
                                    ],
                                    'date2' => [
                                        'type' => 'string',
                                        'format' => 'date',
                                        'description' => 'La deuxième date de la première plage (YYYY-MM-DD)'
                                    ],
                                    'focus' => [
                                        'type' => 'string',
                                        'format' => 'string',
                                    ],
                                    'message' => [
                                        'type' => 'string',
                                        'format' => 'string',
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'summary' => 'Récupérer des utilisateurs entre deux plages de dates',
                'description' => 'Cette opération retourne des utilisateurs dont la date de création se trouve entre les deux plages de dates spécifiées.'
            ],
            read: false,
            name: 'post_rapport_data',
        ),
    ]
)]
class RapportData
{
}