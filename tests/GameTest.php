<?php
/**
 * Maarten van Leeuwen <maarten@significantbits.nl>
 * 26-6-15 22:54
 */ 

namespace Mooph;


class GameTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function new_game_starts_with_an_empty_board()
    {
        $game = Game::create(new CrossPlayer('crosser', new Brain()), new NoughtPlayer('noughty', new Brain()));

        $this->assertEquals(new Board(3,3), $game->board());
    }

    /** @test */
    public function game_can_be_restored()
    {
        $crosser = new CrossPlayer('crosser', new Brain());
        $noughty = new NoughtPlayer('noughty', new Brain());

        $board = new Board(3,3);
        $board->play($crosser, 1, 1);
        $board->play($noughty, 0, 0);
        $board->play($crosser, 2, 1);

        $game = Game::restore($board, $crosser, $noughty);

        $this->assertEquals($board, $game->board());
        $this->assertSame($crosser, $game->crossPlayer());
        $this->assertSame($noughty, $game->noughtPlayer());
    }
}