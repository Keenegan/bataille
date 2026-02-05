<?php

declare(strict_types=1);

namespace Src;

use Src\Game\Bataille;
use Src\Game\GameInterface;

final class GameRunner
{
    /**
     * Entrypoint of the program, you can create more Batailles, add more players, or change the deck size
     *
     * Exemple :
     * $this->run(new Bataille(
     *     [new Player("John"), new Player("Doe"), new Player("Lorem")],
     *     30
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

        echo 'Classement de la partie de ' . $game->getGameName() . PHP_EOL;
        echo str_repeat('-', 40) . PHP_EOL;

        $this->printRanking($game);
    }

    private function printRanking(GameInterface $game): void
    {
        $players = $game->getPlayers();

        usort(
            $players,
            static fn ($a, $b) => $b->getScore() <=> $a->getScore()
        );

        foreach ($players as $player) {
            echo sprintf(
                "%s : %d points%s",
                $player->getName(),
                $player->getScore(),
                PHP_EOL
            );
        }
    }
}
