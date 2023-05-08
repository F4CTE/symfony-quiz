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

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: WrongAnswer::class, orphanRemoval: true)]
    private Collection $wrongAnswers;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: RightAnswer::class, orphanRemoval: true)]
    private Collection $rightAnswers;

    public function __construct()
    {
        $this->wrongAnswers = new ArrayCollection();
        $this->rightAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, WrongAnswer>
     */
    public function getWrongAnswers(): Collection
    {
        return $this->wrongAnswers;
    }

    public function addWrongAnswer(WrongAnswer $wrongAnswer): self
    {
        if (!$this->wrongAnswers->contains($wrongAnswer)) {
            $this->wrongAnswers->add($wrongAnswer);
            $wrongAnswer->setQuestion($this);
        }

        return $this;
    }

    public function removeWrongAnswer(WrongAnswer $wrongAnswer): self
    {
        if ($this->wrongAnswers->removeElement($wrongAnswer)) {
            // set the owning side to null (unless already changed)
            if ($wrongAnswer->getQuestion() === $this) {
                $wrongAnswer->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RightAnswer>
     */
    public function getRightAnswers(): Collection
    {
        return $this->rightAnswers;
    }

    public function addRightAnswer(RightAnswer $rightAnswer): self
    {
        if (!$this->rightAnswers->contains($rightAnswer)) {
            $this->rightAnswers->add($rightAnswer);
            $rightAnswer->setQuestion($this);
        }

        return $this;
    }

    public function removeRightAnswer(RightAnswer $rightAnswer): self
    {
        if ($this->rightAnswers->removeElement($rightAnswer)) {
            // set the owning side to null (unless already changed)
            if ($rightAnswer->getQuestion() === $this) {
                $rightAnswer->setQuestion(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getText() ?? '';
    }
}
