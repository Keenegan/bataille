<?php

interface CardGame
{

    public function isGameOver(array $deck): bool;

    public function round(): void;

    public function printScore(): void;
}

class Bataille implements CardGame
{
    /**
     * @var Player[]
     */
    public array $players;

    /**
     * @var Card[]
     */
    public array $deck;

    public function __construct()
    {
        $this->prepareDeck();
        $this->preparePlayers();
    }

    private function preparePlayers(): void
    {
        $this->players = [
            new Player("Joueur 1"),
            new Player("Joueur 2"),
        ];
    }

    private function prepareDeck(): void
    {
        $deck = [];

        for ($i = 1; $i <= 52; $i++) {
            $deck[] = new Card($i);
        }

        shuffle($deck);
        $this->deck = $deck;
    }

    public function round(): void
    {
        if ($this->isGameOver($this->deck)) {
            return;
        }

        $playedCards = [];

        foreach ($this->players as $player) {
            $card = array_shift($this->deck);
            $playedCards[] = [
                'player' => $player,
                'card' => $card
            ];
        }

        usort($playedCards, function ($a, $b) {
            return $b['card']->value <=> $a['card']->value;
        });

        $winner = $playedCards[0]['player'];
        $winner->score++;
    }

    public function isGameOver(array $deck): bool
    {
        return count($deck) < count($this->players);
    }

    public function printScore(): void
    {
        foreach ($this->players as $player) {
            echo $player->name . " : " . $player->score . " points\n";
        }
    }
}

class Player
{
    public string $name;
    public int $score = 0;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

class Card
{
    public int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}

$game = new Bataille();

while (!$game->isGameOver($game->deck)) {
    $game->round();
}

$game->printScore();