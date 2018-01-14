<?php
declare(strict_types=1);

namespace Meetup\Form;

use Meetup\Entity\Meetup;
use Doctrine\ORM\EntityManager;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Date;
use Zend\Validator\StringLength;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class MeetupForm extends Form implements InputFilterProviderInterface
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('meetup');
        $hydrator = new DoctrineHydrator($entityManager, Meetup::class);
        $this->setHydrator($hydrator);
        $this->add([
            'type' => Element\Text::class,
            'name' => 'title',
            'options' => [
                'label' => 'Titre',
                'class' => 'form-control'
            ],
            'attributes' => [
                'class' => 'form-control'
            ],
        ]);
        $this->add([
            'type' => Element\Textarea::class,
            'name' => 'description',
            'options' => [
                'label' => 'Description',
            ],
            'attributes' => [
                'class' => 'form-control',
                'cols' => '35',
                'rows' => '5'
            ],
        ]);
        $this->add([
            'type' => Element\Date::class,
            'name' => 'startDate',
            'options' => [
                'label' => 'Date début',
            ],
            'attributes' => [
                'class' => 'form-control'
            ],
        ]);
        $this->add([
            'type' => Element\Date::class,
            'name' => 'endDate',
            'options' => [
                'label' => 'Date fin',
            ],
            'attributes' => [
                'class' => 'form-control'
            ],
        ]);

        $this->add([
            'type' => Element\Submit::class,
            'name' => 'submit',
            'attributes' => [
                'class' => 'btn btn-primary',
                'value' => 'Valider'
            ],
        ]);
    }
    public function getInputFilterSpecification()
    {
        return [
            'title' => [
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 2,
                            'max' => 45,
                        ],
                    ],
                ],
            ],
            'startDate' => [
                'validators' => [
                    [
                        'name' => Date::class,
                    ],
                ],
                'filters' => [
                    [
                        'name' => 'Zend\Filter\DatetimeFormatter',
                        'options' => [
                            'format' => 'Y-m-d',
                        ],
                    ]
                ]
            ],
            'endDate' => [
                'validators' => [
                    [
                        'name' => Date::class,
                    ],
                ],
                'filters' => [
                    [
                        'name' => 'Zend\Filter\DatetimeFormatter',
                        'options' => [
                            'format' => 'Y-m-d',
                        ],
                    ]
                ]
            ],
        ];
    }
}