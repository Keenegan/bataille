<?php

namespace Src\Game;

use Src\Domain\Card;
use Src\Domain\Player;


class Bataille implements GameInterface
{

    public const int DEFAULT_DECK_SIZE = 52;

    /**
     * @var Player[]
     */
    private array $players;
    public int $deckSize;

    public function __construct(array $players = [], int $deckSize = self::DEFAULT_DECK_SIZE)
    {
        $this->players = $players ?: [
            new Player("Joueur 1"),
            new Player("Joueur 2")
        ];

        $this->deckSize = $deckSize < \count($players) ? self::DEFAULT_DECK_SIZE : $deckSize;

        $this->prepareGame();
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getGameName(): string
    {
        return "bataille";
    }

    private function prepareGame(): void
    {
        $deck = [];

        for ($i = 1; $i <= $this->deckSize; $i++) {
            $deck[] = new Card($i);
        }

        shuffle($deck);

        $decks = array_chunk($deck, ceil($this->deckSize / \count($this->players)));
        foreach ($this->players as $key => $player) {
            $player->setHand($decks[$key]);
        }
    }

    public function round(): void
    {
        $playedCards = [];

        foreach ($this->players as $player) {
            if (!$player->hasCards()) {
                return;
            }
            $card = $player->playFirstCard();

            $playedCards[] = [
                'player' => $player,
                'card' => $card
            ];
        }

        usort($playedCards, function ($a, $b) {
            return $b['card']->value <=> $a['card']->value;
        });

        $winner = $playedCards[0]['player'];
        $winner->addPoint();
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