<?php

declare(strict_types=1);

namespace Publicaciones;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
	'router' => [
    	'routes' => [
            'articulos' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/articulos',
                    'defaults' => [
                        'controller' => Controller\ArticulosController::class,
                        'action' => 'index'
                    ],
                ],
            ],
            'addarticulo' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/addarticulo',
                    'defaults' => [
                        'controller' => Controller\ArticulosController::class,
                        'action' => 'create'
                    ],
                ],
            ],
            'imagen' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/imagen',
                    'defaults' => [
                        'controller' => Controller\ArticulosController::class,
                        'action' => 'imagen'
                    ],
                ],
            ],
            'updatearticulo' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/updatearticulo',
                    'defaults' => [
                        'controller' => Controller\ArticulosController::class,
                        'action' => 'update'
                    ],
                ],
            ],
            'deletearticulo' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/deletearticulo',
                    'defaults' => [
                        'controller' => Controller\ArticulosController::class,
                        'action' => 'delete'
                    ],
                ],
            ],
             'publicados' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/publicados',
                    'defaults' => [
                        'controller' => Controller\ArticulosController::class,
                        'action' => 'publicados'
                    ],
                ],
            ],
            'readarticulo' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/readarticulo',
                    'defaults' => [
                        'controller' => Controller\ArticulosController::class,
                        'action' => 'readarticulo'
                    ],
                ],
            ],

            'megusta' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/megusta',
                    'defaults' => [
                        'controller' => Controller\ArticulosController::class,
                        'action' => 'megusta'
                    ],
                ],
            ],

              'nomegusta' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/nomegusta',
                    'defaults' => [
                        'controller' => Controller\ArticulosController::class,
                        'action' => 'nomegusta'
                    ],
                ],
            ],


    	],
    ],
    'controllers' => [
    	'factories' => [
            Controller\ArticulosController::class => Controller\Factory\ArticulosControllerFactory::class,
        ],
    ],
    'view_manager' => [
    	'template_map' => [
    		'articulos/index'   => __DIR__ . '/../view/publicaciones/articulos/index.phtml',
            'addarticulo/create'   => __DIR__ . '/../view/publicaciones/articulos/create.phtml',
            'updatearticulo/update'   => __DIR__ . '/../view/publicaciones/articulos/update.phtml',
            'publicados/publicados'   => __DIR__ . '/../view/publicaciones/articulos/publicados.phtml',
            'readarticulo/readarticulo'   => __DIR__ . '/../view/publicaciones/articulos/readarticulo.phtml',
    	],
    	'template_path_stack' => [
    		'publicaciones' => __DIR__ . '/../view'
    	]
    ]
];