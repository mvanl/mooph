<?php
namespace Mooph;

use \Mooph\Exceptions\NonEmptyCellException;
/**
 * Maarten van Leeuwen <maarten@significantbits.nl>
 * 26-6-15 21:10
 */ 

class Board
{
    private $maxCol;

    private $maxRow;

    /** @var array */
    private $cells;


    public function __construct($cols, $rows)
    {
        $this->cols = $cols;
        $this->rows = $rows;

        $this->clear();
    }

    private function clear()
    {
        $this->cells = array_fill_keys(
            range(0, $this->cols - 1),
            array_fill_keys(
                range(0, $this->rows - 1),
                new Cell(null)
            )
        );
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
                    $this->cols - 1,
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

        $this->assertWithinBounds($col, $this->cols);
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
     *
     * @return Cell
     *
     * @throws \OutOfBoundsException
     */
    public function at($col, $row)
    {
        $this->assertCoordinatesWithinBounds($col, $row);

        return $this->cells[$col][$row];
    }

    /**
     * @return array
     */
    public function cells()
    {
        return $this->cells;
    }

    /**
     * @return aint
     */
    public function cols()
    {
        return $this->cols;
    }

    public function rows()
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

        $this->cells[$col][$row] = new Cell($player);
    }
}




