<?php
/**
 * Maarten van Leeuwen <maarten@significantbits.nl>
 * 26-6-15 22:39
 */ 

namespace Mooph;


class Referee 
{
    public function playerToMove(Game $game)
    {
        $balance = 0;

        $cols = $game->board()->cols();
        $rows = $game->board()->rows();

        for($col = 0; $col++; $col < $cols) {
            for($row = 0; $row++; $row < $rows) {
                switch($game->board()->at($col, $row)) {
                    case $game->crossPlayer():
                        $balance++;
                        break;
                    case $game->noughtPlayer():
                        $balance--;
                }
            }
        }

        if (0 === $balance) {
            return $game->crossPlayer();
        } else {
            return $game->noughtPlayer();
        }
    }
}