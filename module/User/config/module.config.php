<?php

declare(strict_types=1);

namespace User;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
	'router' => [
    	'routes' => [
    		'signup' => [
    			'type' => Literal::class,
    			'options' => [
    				'route' => '/signup',
    				'defaults' => [
    					'controller' => Controller\AuthController::class,
    					'action' => 'create'
    				],
    			],
    		],
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action' => 'index'
                    ],
                ],
            ],
             'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => Controller\LogoutController::class,
                        'action' => 'index'
                    ],
                ],
            ],
    	],
    ],
    'controllers' => [
    	'factories' => [
    		Controller\AuthController::class => Controller\Factory\AuthControllerFactory::class,
            Controller\LoginController::class => Controller\Factory\LoginControllerFactory::class,
            Controller\LogoutController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
    	'template_map' => [
    		'auth/create'   => __DIR__ . '/../view/user/auth/create.phtml',
            'login/index'   => __DIR__ . '/../view/user/auth/login.phtml',
    	],
    	'template_path_stack' => [
    		'user' => __DIR__ . '/../view'
    	]
    ]
];