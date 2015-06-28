<?php
namespace Mooph;

use \Mooph\Exceptions\NonEmptyCellException;
/**
 * Maarten van Leeuwen <maarten@significantbits.nl>
 * 26-6-15 21:10
 */ 

class Board
{
    private $rows;
    private $columns;

    /**
     * For efficient array handling the rows of the board are concatenated in a flattened array
     * @var array
     */
    private $cells;


    public function __construct($cols, $rows)
    {
        $this->columns = $cols;
        $this->rows = $rows;

        $this->clear();
    }

    /**
     */
    private function clear()
    {
        $this->cells = array_fill(0, $this->columns * $this->rows, new Cell(null));
    }

    /**
     * @param int $value
     * @param int $upper
     *
     * @throws \OutOfBoundsException
     */
    private function assertWithinBounds($value, $upper)
    {
        if (0 > $value || $value > $upper) {
            throw new \OutOfBoundsException(
                sprintf(
                    'Column and row values must be at least 0. Max column value is %d, Max row value is %d',
                    $this->columns - 1,
                    $this->rows - 1
                )
            );
        }
    }

    /**
     * @param int $col
     * @param int $row
     *
     * @throws \OutOfBoundsException
     */
    private function assertCoordinatesWithinBounds(&$col, &$row)
    {
        $col = (int) $col;
        $row = (int) $row;

        $this->assertWithinBounds($col, $this->columns);
        $this->assertWithinBounds($row, $this->rows);
    }

    /**
     * @param int $col
     * @param int $row
     * @throws NonEmptyCellException
     */
    private function assertBoardIsEmptyAt($col, $row)
    {
        if (!is_null($this->at($col, $row)->owner())) {
            throw new NonEmptyCellException;
        }
    }

    /**
     * @param int $col
     * @param int $row
     * @return int
     */
    private function index($col, $row)
    {
        return $col + $row * $this->columns;
    }

    /**
     * @param int $col
     * @param int $row
     *
     * @return Cell
     *
     * @throws \OutOfBoundsException
     */
    public function at($col, $row)
    {
        $this->assertCoordinatesWithinBounds($col, $row);

        return $this->cells[$this->index($col, $row)];
    }

    /**
     * @param $col
     * @param $row
     * @return Player
     */
    public function ownerAt($col, $row)
    {
        $cell = $this->at($col, $row);
        return $cell->owner();
    }

    /**
     * @return array
     */
    public function cells()
    {
        return $this->cells;
    }

    /**
     * @return int
     */
    public function colCount()
    {
        return $this->columns;
    }

    public function rowCount()
    {
        return $this->rows;
    }

    /**
     * @param Player $player
     * @param int $col
     * @param int $row
     *
     * @throws \OutOfBoundsException
     * @throws NonEmptyCellException
     */
    public function play(Player $player, $col, $row)
    {
        $this->assertCoordinatesWithinBounds($col, $row);
        $this->assertBoardIsEmptyAt($col, $row);

        $this->cells[$this->index($col, $row)] = new Cell($player);
    }
}