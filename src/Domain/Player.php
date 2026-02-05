<?php

declare(strict_types=1);

namespace Src\Domain;

final class Player
{
    private string $name;
    private int $score = 0;

    /**
     * @var Card[]
     */
    private array $hand = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function playFirstCard(): ?Card
    {
        return array_shift($this->hand);
    }

    /**
     * @param Card[] $hand
     */
    public function setHand(array $hand): void
    {
        $this->hand = $hand;
    }

    public function hasCards(): bool
    {
        return !empty($this->hand);
    }

    public function addPoint(): void
    {
        $this->score++;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
