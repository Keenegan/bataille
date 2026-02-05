<?php

declare(strict_types=1);

namespace Src\Game;

use Src\Domain\Card;
use Src\Domain\Player;

final class Bataille implements GameInterface
{
    public const DEFAULT_DECK_SIZE = 52;

    /**
     * @var Player[]
     */
    private array $players;

    private int $deckSize;

    /**
     * @param Player[] $players
     */
    public function __construct(array $players = [], int $deckSize = self::DEFAULT_DECK_SIZE)
    {
        $this->players = $players ?: [
            new Player('Joueur 1'),
            new Player('Joueur 2'),
        ];

        $this->deckSize = $deckSize < count($this->players)
            ? self::DEFAULT_DECK_SIZE
            : $deckSize;

        $this->prepareGame();
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getGameName(): string
    {
        return 'bataille';
    }

    private function prepareGame(): void
    {
        $deck = [];

        for ($i = 1; $i <= $this->deckSize; $i++) {
            $deck[] = new Card($i);
        }

        shuffle($deck);

        $cardsPerPlayer = (int) ceil($this->deckSize / count($this->players));
        $decks = array_chunk($deck, $cardsPerPlayer);

        foreach ($this->players as $index => $player) {
            $player->setHand($decks[$index] ?? []);
        }
    }

    public function round(): void
    {
        $playedCards = [];

        foreach ($this->players as $player) {
            if (!$player->hasCards()) {
                return;
            }

            $playedCards[] = [
                'player' => $player,
                'card'   => $player->playFirstCard(),
            ];
        }

        usort(
            $playedCards,
            static fn ($a, $b) => $b['card']->getValue() <=> $a['card']->getValue()
        );

        $playedCards[0]['player']->addPoint();
    }

    public function isGameOver(): bool
    {
        foreach ($this->players as $player) {
            if (!$player->hasCards()) {
                return true;
            }
        }

        return false;
    }
}
