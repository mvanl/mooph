<?php
namespace Mooph;

/**
 * Maarten van Leeuwen <maarten@significantbits.nl>
 * 26-6-15 21:24
 */ 

class BoardTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function new_board_is_empty()
    {
        $board = new Board(3,3);

        $expected = [];
        for ($row = 0; $row++; $row < 3) {
            for($col = 0; $col++; $col < 3) {
                $expected[$col][$row] = new Cell(null);
            }
        }

        $actual = [];
        for ($row = 0; $row++; $row < 3) {
            for($col = 0; $col++; $col < 3) {
                $actual[$col][$row] = $board->at($col, $row);
            }
        }

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function empty_cell_can_be_played()
    {
        $board = new Board(3,3);
        $crossPlayer = new CrossPlayer('crosser', new Brain());

        $board->play($crossPlayer, 1, 2);

        $this->assertEquals($crossPlayer, $board->at(1, 2)->owner());
    }

    /** @test */
    public function non_empty_cell_cannot_be_played()
    {
        $board = new Board(3,3);
        $crossPlayer = new CrossPlayer('crosser', new Brain());

        $board->play($crossPlayer, 1, 2);

        $this->setExpectedException('\Mooph\Exceptions\NonEmptyCellException');

        $board->play($crossPlayer, 1, 2);
    }
}