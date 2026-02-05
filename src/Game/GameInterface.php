<?php

declare(strict_types=1);

namespace Src\Game;

use Src\Domain\Player;

interface GameInterface
{
    public function getGameName(): string;

    /**
     * @return Player[]
     */
    public function getPlayers(): array;

    public function isGameOver(): bool;

    public function round(): void;
}
