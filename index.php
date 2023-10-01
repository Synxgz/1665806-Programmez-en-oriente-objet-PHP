<?php

declare(strict_types=1);

class Player
{
    private int $level;

    public function __construct(int $level)
    {
        $this->level = $level;
    }

    public function getLevel(): int
    {
        return $this->level;
    }
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }
}

class QueuingPlayer extends Player
{
    private int $range;
}

class Encounter
{
    public const RESULT_WINNER = 1;
    public const RESULT_LOSER = -1;
    public const RESULT_DRAW = 0;
    public const RESULT_POSSIBILITIES = [self::RESULT_WINNER, self::RESULT_LOSER, self::RESULT_DRAW];

    public static function probabilityAgainst(Player $levelPlayerOne, Player $againstLevelPlayerTwo): float
    {
        return 1/(1+(10 ** (($againstLevelPlayerTwo->getLevel() - $levelPlayerOne->getLevel())/400)));
    }

    public static function setNewLevel(Player &$levelPlayerOne, Player $againstLevelPlayerTwo, int $playerOneResult)
    {
        if (!in_array($playerOneResult, self::RESULT_POSSIBILITIES)) {
            trigger_error(sprintf('Invalid result. Expected %s',implode(' or ', self::RESULT_POSSIBILITIES)));
        }
    
        $levelPlayerOne->setLevel((int) ($levelPlayerOne->getLevel() + 32 * ($playerOneResult - self::probabilityAgainst($levelPlayerOne, $againstLevelPlayerTwo))));
    }
}

$greg = new Player(400);
$jade = new Player(800);

echo sprintf(
	'Greg à %.2f%% chance de gagner face a Jade', 
	Encounter::probabilityAgainst($greg, $jade)*100
).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
Encounter::setNewLevel($greg, $jade, Encounter::RESULT_WINNER);
Encounter::setNewLevel($jade, $greg, Encounter::RESULT_LOSER);

echo sprintf(
	'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade', 
	$greg->getLevel(),
	$jade->getLevel()
);

exit(0);