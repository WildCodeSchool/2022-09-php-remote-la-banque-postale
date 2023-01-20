<?php

namespace App\Entity;

use App\Repository\TutorielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TutorielRepository::class)]
#[UniqueEntity(fields: ['title'], message: 'There is already tutoriel with this title')]
class Tutoriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'tutoriels')]
    private ?Level $level = null;

    #[ORM\ManyToOne(inversedBy: 'tutoriels')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'tutoriel', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'tutoriel', targetEntity: Question::class, cascade: ['persist'])]
    private ?Collection $questions;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favori')]
    private Collection $learners;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->learners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTutoriel($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTutoriel() === $this) {
                $comment->setTutoriel(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): ?Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setTutoriel($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getTutoriel() === $this) {
                $question->setTutoriel(null);
            }
        }

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLearners(): Collection
    {
        return $this->learners;
    }

    public function addLearner(User $learner): self
    {
        if (!$this->learners->contains($learner)) {
            $this->learners->add($learner);
            $learner->addFavori($this);
        }

        return $this;
    }

    public function removeLearner(User $learner): self
    {
        if ($this->learners->removeElement($learner)) {
            $learner->removeFavori($this);
        }

        return $this;
    }
}
