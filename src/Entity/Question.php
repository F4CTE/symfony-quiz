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

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Answer::class, orphanRemoval: true)]
    private Collection $rightAnswer;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Answer::class)]
    private Collection $wgrongAnswer;

    public function __construct()
    {
        $this->rightAnswer = new ArrayCollection();
        $this->wgrongAnswer = new ArrayCollection();
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
     * @return Collection<int, Answer>
     */
    public function getRightAnswer(): Collection
    {
        return $this->rightAnswer;
    }

    public function addRightAnswer(Answer $rightAnswer): self
    {
        if (!$this->rightAnswer->contains($rightAnswer)) {
            $this->rightAnswer->add($rightAnswer);
            $rightAnswer->setQuestion($this);
        }

        return $this;
    }

    public function removeRightAnswer(Answer $rightAnswer): self
    {
        if ($this->rightAnswer->removeElement($rightAnswer)) {
            // set the owning side to null (unless already changed)
            if ($rightAnswer->getQuestion() === $this) {
                $rightAnswer->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getWgrongAnswer(): Collection
    {
        return $this->wgrongAnswer;
    }

    public function addWgrongAnswer(Answer $wgrongAnswer): self
    {
        if (!$this->wgrongAnswer->contains($wgrongAnswer)) {
            $this->wgrongAnswer->add($wgrongAnswer);
            $wgrongAnswer->setQuestion($this);
        }

        return $this;
    }

    public function removeWgrongAnswer(Answer $wgrongAnswer): self
    {
        if ($this->wgrongAnswer->removeElement($wgrongAnswer)) {
            // set the owning side to null (unless already changed)
            if ($wgrongAnswer->getQuestion() === $this) {
                $wgrongAnswer->setQuestion(null);
            }
        }

        return $this;
    }
}
