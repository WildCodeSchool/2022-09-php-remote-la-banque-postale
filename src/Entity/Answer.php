<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $isCorrect = null;


    #[ORM\OneToMany(mappedBy: 'answer', targetEntity: GameAnswer::class)]
    private Collection $gameAnswers;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    private ?Question $question = null;

    public function __construct()
    {
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

    public function isIscorrect(): ?bool
    {
        return $this->isCorrect;
    }

    public function setIscorrect(bool $isCorrect): self
    {
        $this->isCorrect = $isCorrect;

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
            $gameAnswer->setAnswer($this);
        }

        return $this;
    }

    public function removeGameAnswer(GameAnswer $gameAnswer): self
    {
        if ($this->gameAnswers->removeElement($gameAnswer)) {
            // set the owning side to null (unless already changed)
            if ($gameAnswer->getAnswer() === $this) {
                $gameAnswer->setAnswer(null);
            }
        }

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
