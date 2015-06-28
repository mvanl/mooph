<?php
/**
 * Maarten van Leeuwen <maarten@significantbits.nl>
 * 26-6-15 23:38
 */ 

namespace Mooph;


class RefereeTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function cross_player_moves_first()
    {
        $crossPlayer = new CrossPlayer('crosser', new Brain());
        $noughtPlayer = new NoughtPlayer('noughty', new Brain());
        $game = Game::create(
            $crossPlayer,
            $noughtPlayer
        );

        $referee = new Referee();

        $this->assertSame($crossPlayer, $referee->playerToMove($game));
    }

    /** @test */
    public function players_take_turns()
    {
        $crossPlayer = new CrossPlayer('crosser', new Brain());
        $noughtPlayer = new NoughtPlayer('noughty', new Brain());
        $game = Game::create(
            $crossPlayer,
            $noughtPlayer
        );

        $referee = new Referee();

        $game->board()->play($crossPlayer, 0, 0);

        $this->assertSame($noughtPlayer, $referee->playerToMove($game));

        $game->board()->play($noughtPlayer, 1, 1);

        $this->assertSame($crossPlayer, $referee->playerToMove($game));
    }

    /** @test */
    public function number_of_played_moves_is_counted_correctly()
    {
        $crossPlayer = new CrossPlayer('crosser', new Brain());
        $noughtPlayer = new NoughtPlayer('noughty', new Brain());
        $game = Game::create(
            $crossPlayer,
            $noughtPlayer,
            3,
            3
        );

        $referee = new Referee();

        $this->assertEquals(0, $referee->playedMovesCount($game));

        $game->board()->play($crossPlayer, 0, 0);

        $this->assertEquals(1, $referee->playedMovesCount($game));

        $game->board()->play($noughtPlayer, 1, 1);
        $game->board()->play($crossPlayer, 2, 2);
        $game->board()->play($noughtPlayer, 1, 2);

        $this->assertEquals(4, $referee->playedMovesCount($game));
    }

    /** @test */
    function game_ends_when_player_plays_all_cells_in_a_row()
    {
        $crossPlayer = new CrossPlayer('crosser', new Brain());
        $noughtPlayer = new NoughtPlayer('noughty', new Brain());
        $game = Game::create(
            $crossPlayer,
            $noughtPlayer,
            3,
            3
        );

        $game->board()->play($crossPlayer, 0, 1);
        $game->board()->play($noughtPlayer, 0, 0);
        $game->board()->play($crossPlayer, 1, 1);
        $game->board()->play($noughtPlayer, 2, 2);
        $game->board()->play($crossPlayer, 2, 1);

        $referee = new Referee();

        $this->assertTrue($referee->gameEnded($game));
    }

    /** @test */
    function game_ends_when_player_plays_all_cells_in_a_column()
    {
        $crossPlayer = new CrossPlayer('crosser', new Brain());
        $noughtPlayer = new NoughtPlayer('noughty', new Brain());
        $game = Game::create(
            $crossPlayer,
            $noughtPlayer,
            3,
            3
        );

        $game->board()->play($crossPlayer, 1,0);
        $game->board()->play($noughtPlayer, 0, 0);
        $game->board()->play($crossPlayer, 1, 1);
        $game->board()->play($noughtPlayer, 2, 2);
        $game->board()->play($crossPlayer, 1, 2);

        $referee = new Referee();

        $this->assertTrue($referee->gameEnded($game));
    }

    /** @test */
    function game_ends_when_player_plays_all_cells_in_diagonal_starting_top_left()
    {
        $crossPlayer = new CrossPlayer('crosser', new Brain());
        $noughtPlayer = new NoughtPlayer('noughty', new Brain());
        $game = Game::create(
            $crossPlayer,
            $noughtPlayer,
            3,
            3
        );

        $game->board()->play($crossPlayer, 0,0);
        $game->board()->play($noughtPlayer, 1, 0);
        $game->board()->play($crossPlayer, 1, 1);
        $game->board()->play($noughtPlayer, 0, 1);
        $game->board()->play($crossPlayer, 2, 2);

        $referee = new Referee();

        $this->assertTrue($referee->gameEnded($game));
    }

    /** @test */
    function game_ends_when_player_plays_all_cells_in_diagonal_starting_top_right()
    {
        $crossPlayer = new CrossPlayer('crosser', new Brain());
        $noughtPlayer = new NoughtPlayer('noughty', new Brain());
        $game = Game::create(
            $crossPlayer,
            $noughtPlayer,
            3,
            3
        );

        $game->board()->play($crossPlayer, 2,0);
        $game->board()->play($noughtPlayer, 1, 0);
        $game->board()->play($crossPlayer, 1, 1);
        $game->board()->play($noughtPlayer, 0, 1);
        $game->board()->play($crossPlayer, 0, 2);

        $referee = new Referee();

        $this->assertTrue($referee->gameEnded($game));
    }
}