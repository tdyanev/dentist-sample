<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
#[UniqueEntity(
    fields: ['date'],
    // errorPath: 'port',
    message: 'This is already booked!',
)]

class Appointment {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    // #[Assert\Regex(
    //     pattern: '/^\d{4}\-\d{2}-\d{2} \d{2}:\d{2}$/',
    //     message: 'Date should be like YYYY-MM-DD H:m'
    //     // htmlPattern: '^[a-zA-Z]+$'
    // )]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDay(): string {
        return $this->getDate()->format('d');
    }

    public function getTime(): string {
        return $this->getDate()->format('H:i');
    }

    public function getFullDate(): string {
        return $this->getDate()->format('Y-m-d');
    }

}
