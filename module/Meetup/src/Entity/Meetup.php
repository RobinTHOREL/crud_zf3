<?php

declare(strict_types=1);

namespace Meetup\Entity;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Meetup
 * @package Meetup\Entity
 * @ORM\Entity(repositoryClass="\Meetup\Repository\MeetupRepository")
 * @ORM\Table(name="meetups")
 */
class Meetup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36)
     **/
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=2000, nullable=false)
     */
    private $description = '';

    /**
     * @ORM\Column(type="datetime", name="start_date", nullable=false)
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", name="end_date", nullable=false)
     */
    private $endDate;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */

    public function getTitle() : string
    {
        return $this->title;
    }
    public function setTitle(string $title) :void
    {
        $this->title = $title;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    public function getStartDate() : \DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate) : void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate() : \DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate) : void
    {
        $this->endDate = $endDate;
    }
}
