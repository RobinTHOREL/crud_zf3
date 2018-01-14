<?php

declare(strict_types=1);

namespace Meetup\Controller;

use Meetup\Entity\Meetup;
use Meetup\Form\MeetupForm;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

final class IndexControllerFactory
{
    public function __invoke(ContainerInterface $container) : IndexController
    {
        $MeetupRepository = $container->get(EntityManager::class)->getRepository(Meetup::class);
        $MeetupForm = $container->get(MeetupForm::class);

        return new IndexController($MeetupRepository, $MeetupForm);
    }
}
