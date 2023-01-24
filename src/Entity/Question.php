<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    private ?Tutoriel $tutoriel = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Answer::class, cascade: ['persist', 'remove'])]
    private Collection $answers;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: GameAnswer::class)]
    private Collection $gameAnswers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->gameAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTutoriel(): ?Tutoriel
    {
        return $this->tutoriel;
    }

    public function setTutoriel(?Tutoriel $tutoriel): self
    {
        $this->tutoriel = $tutoriel;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GameAnswer>
     */
    public function getGameAnswers(): Collection
    {
        return $this->gameAnswers;
    }

    public function addGameAnswer(GameAnswer $gameAnswer): self
    {
        if (!$this->gameAnswers->contains($gameAnswer)) {
            $this->gameAnswers->add($gameAnswer);
            $gameAnswer->setQuestion($this);
        }

        return $this;
    }

    public function removeGameAnswer(GameAnswer $gameAnswer): self
    {
        if ($this->gameAnswers->removeElement($gameAnswer)) {
            // set the owning side to null (unless already changed)
            if ($gameAnswer->getQuestion() === $this) {
                $gameAnswer->setQuestion(null);
            }
        }

        return $this;
    }
}
