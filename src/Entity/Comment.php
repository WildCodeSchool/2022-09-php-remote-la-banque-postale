<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Tutoriel $tutoriel = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    private null|User|UserInterface $user = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $postedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $author = null;

    public function __construct()
    {
        $this->postedAt = new DateTimeImmutable('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getTutoriel(): ?Tutoriel
    {
        return $this->tutoriel;
    }

    public function setTutoriel(?Tutoriel $tutoriel): self
    {
        $this->tutoriel = $tutoriel;

        return $this;
    }

    public function getUser(): null|User|UserInterface
    {
        return $this->user;
    }

    public function setUser(null|User|UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPostedAt(): ?\DateTimeImmutable
    {
        return $this->postedAt;
    }

    public function setPostedAt(?\DateTimeImmutable $postedAt): self
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }
}
