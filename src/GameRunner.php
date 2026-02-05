<?php

namespace Src;

use Src\Game\Bataille;
use Src\Game\GameInterface;

class GameRunner
{

    /**
     * Entrypoint of the program, you can create more Batailles, add more players, or change the deck size
     * 
     * Example :
     * $this->run(new Bataille(
     *  [new Player("Jhon"), new Player("Doe"), new Player("Lorem")],
     *  30
     * ));
     */
    public function __construct()
    {
        // Creates a default bataille with 2 players and 52 cards
        $this->run(new Bataille());
    }

    public function run(GameInterface $game): void
    {
        while (!$game->isGameOver()) {
            $game->round();
        }

        echo "Classement de la partie de " . $game->getGameName() . PHP_EOL;
        $this->printWinner($game);
    }

    public function printWinner(GameInterface $game): void
    {
        $players = $game->getPlayers();
        usort($players, fn($a, $b) => $b->getScore() <=> $a->getScore());
        foreach ($players as $player) {
            echo $player->getName() . " : " . $player->getScore() . " points\n";
        }
    }
}
