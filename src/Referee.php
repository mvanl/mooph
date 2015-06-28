<?php
/**
 * Maarten van Leeuwen <maarten@significantbits.nl>
 * 26-6-15 22:39
 */ 

namespace Mooph;


class Referee 
{
    /**
     * @param Game $game
     * @return int
     */
    public function playedMovesCount(Game $game)
    {
        return array_reduce(
            $game->board()->cells(),
            function($carry, $cell) {
                /** @var Cell $cell */
                if (is_null($cell->owner())) {
                    return $carry;
                } else {
                    return ++$carry;
                }
            },
            0
        );
    }

    /**
     * @param Board $board
     * @param int $col
     * @return bool
     */
    private function isWinningColumn(Board $board, $col)
    {
        $player = $board->ownerAt($col, 0);
        if(is_null($player)) {
            return false;
        }

        for($row = 1; $row < $board->rowCount(); $row++) {
            if ($player != $board->ownerAt($col, $row)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Board $board
     * @return bool
     */
    private function winningColumnExists(Board $board)
    {
        for ($col = 0; $col < $board->colCount(); $col++) {
            if ($this->isWinningColumn($board, $col)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Board $board
     * @param int $row
     * @return bool
     */
    private function isWinningRow(Board $board, $row)
    {
        $player = $board->ownerAt(0, $row);
        if(is_null($player)) {
            return false;
        }

        for($col = 1; $col < $board->colCount(); $col++) {
            if ($player != $board->ownerAt($col, $row)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Board $board
     * @return bool
     */
    private function winningRowExists(Board $board) {
        for ($row = 0; $row < $board->rowCount(); $row++) {
            if ($this->isWinningRow($board, $row)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Board $board
     * @return bool
     */
    private function isWinningDiagonalFromTopLeft(Board $board)
    {
        $player = $board->ownerAt(0,0);
        if (is_null($player)) {
            return false;
        }

        for($row = 1; $row < $board->rowCount(); $row++) {
            if($player != $board->ownerAt($row, $row)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Board $board
     * @return bool
     */
    private function isWinningDiagonalFromTopRight(Board $board)
    {
        $player = $board->ownerAt($board->colCount() - 1, 0);
        if (is_null($player)) {
            return false;
        }

        for($row = 1; $row < $board->rowCount(); $row++) {
            if($player != $board->ownerAt($board->colCount() - $row - 1, $row)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Board $board
     * @return bool
     */
    private function winningDiagonalExists(Board $board)
    {
        return $this->isWinningDiagonalFromTopLeft($board) || $this->isWinningDiagonalFromTopRight($board);
    }

    /**
     * @param Game $game
     * @return bool
     */
    public function gameEnded(Game $game)
    {
        return
            $this->winningColumnExists($game->board()) ||
            $this->winningRowExists($game->board()) ||
            $this->winningDiagonalExists($game->board());;

    }

    /**
     * @param Game $game
     * @return CrossPlayer|NoughtPlayer|null
     */
    public function playerToMove(Game $game)
    {
        if ($this->gameEnded($game)) {
            return null;
        }
        return (0 == $this->playedMovesCount($game) % 2) ? $game->crossPlayer() : $game->noughtPlayer();
    }
}