<?php

declare(strict_types=1);

use Meetup\Form\MeetupForm;
use Meetup\Form\MeetupFormFactory;
use Zend\Router\Http\Literal;
use Meetup\Controller;
use Meetup\Controller\IndexControllerFactory;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'meetups' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/meetups',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/new',
                            'defaults' => [
                                'action'     => 'add',
                            ],
                        ],
                    ],
                    'delete' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/delete',
                            'defaults' => [
                                'action'     => 'delete',
                            ],
                        ],
                    ],
                    'edit' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/edit/:id',
                            'defaults' => [
                                'action'     => 'edit',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => IndexControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            MeetupForm::class => MeetupFormFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'meetup/index/index' => __DIR__ . '/../view/Meetup/index/index.phtml',
            'meetup/index/add' => __DIR__ . '/../view/Meetup/index/add.phtml',
            'meetup/index/edit' => __DIR__ . '/../view/Meetup/index/edit.phtml',
        ],
    ],
    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'Meetup_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../src/Entity/',
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `application_driver` for any entity under namespace `Application\Entity`
                    'Meetup\Entity' => 'Meetup_driver',
                ],
            ],
        ],
    ],
];
