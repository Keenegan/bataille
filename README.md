# Bataille
This is an object-oriented implementation of the French card game “La Bataille”.
It was designed to be easily extendable, allowing the addition of more players, new games or slightly different rules.

## Rules
- A deck of 52 cards is created, numbered from 1 to 52
- The deck is split evenly between two players
- In each round, both players draw one card
- The player with the highest card wins the round
- At the end of the game, the player with the most points wins

## Run the project
- Download the code
- run `composer up` (composer was only used for autoloading)
- run `php index.php` to run the current games (see `GameRunner.php` to add more)

## Architecture
- `Game` folder contains code related to the games (only bataille currently)
- `Domain` folder contains code related to every possible games
- `GameRunner.php` is the entrypoint were you can add more players or change the number of cards in the deck

## Tools Used
- VS Code
- GitHub Copilot