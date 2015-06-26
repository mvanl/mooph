<?php
/**
 * Maarten van Leeuwen <maarten@significantbits.nl>
 * 26-6-15 22:40
 */ 

namespace Mooph;


class Game
{
    const DEFAULT_COLS = 3;
    const DEFAULT_ROWS = 3;

    /** @var Board */
    private $board;

    /** @var CrossPlayer */
    private $crossPlayer;

    /** @var NoughtPlayer */
    private $noughtPlayer;

    /**
     * @param Board $board
     * @param CrossPlayer $crossPlayer
     * @param NoughtPlayer $noughtPlayer
     */
    private function __construct(Board $board, CrossPlayer $crossPlayer, NoughtPlayer $noughtPlayer)
    {
        $this->board = $board;
        $this->crossPlayer = $crossPlayer;
        $this->noughtPlayer = $noughtPlayer;
    }

    /**
     * @param CrossPlayer $crossPlayer
     * @param NoughtPlayer $noughtPlayer
     * @param int $cols
     * @param int $rows
     *
     * @return Game
     */
    public static function create(CrossPlayer $crossPlayer, NoughtPlayer $noughtPlayer, $cols = self::DEFAULT_COLS, $rows = self::DEFAULT_ROWS)
    {
        return new self(new Board($cols, $rows), $crossPlayer, $noughtPlayer);
    }

    /**
     * @param Board $board
     * @param CrossPlayer $crossPlayer
     * @param NoughtPlayer $noughtPlayer
     * @return Game
     */
    public static function restore(Board $board, CrossPlayer $crossPlayer, NoughtPlayer $noughtPlayer)
    {
        return new self($board, $crossPlayer, $noughtPlayer);
    }

    /**
     * @return Board
     */
    public function board()
    {
        return $this->board;
    }

    /**
     * @return CrossPlayer
     */
    public function crossPlayer()
    {
        return $this->crossPlayer;
    }

    /**
     * @return NoughtPlayer
     */
    public function noughtPlayer()
    {
        return $this->noughtPlayer;
    }
}